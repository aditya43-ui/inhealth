<script type="text/javascript">
/**
 * set form kunjungan
 * @param {type} pasien_id
 * @returns {undefined}
 */
function setKunjungan(pasienkirimkeunitlain_id){
    $("#form-datakunjungan > div").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataKunjungan'); ?>',
        data: {pasienkirimkeunitlain_id:pasienkirimkeunitlain_id},
        dataType: "json",
        success:function(data){
            $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'pasienkirimkeunitlain_id')?>").val(data.pasienkirimkeunitlain_id);
            $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'jeniskasuspenyakit_id')?>").val(data.jeniskasuspenyakit_id);
            $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'kelaspelayanan_id')?>").val(data.kelaspelayanan_id);
            $("#pegawai_id").val(data.pegawai_id);
            $("#pendaftaran_id").val(data.pendaftaran_id);
            $("#pasien_id").val(data.pasien_id);
            $("#jeniskasuspenyakit_id").val(data.jeniskasuspenyakit_id);
            $("#carabayar_id").val(data.carabayar_id);
            $("#penjamin_id").val(data.penjamin_id);
            $("#penanggungjawab_id").val(data.penanggungjawab_id);
            $("#instalasiasal_id").val(data.instalasiasal_id);
            $("#ruanganasal_id").val(data.ruanganasal_id);
            $("#kelaspelayanan_id").val(data.kelaspelayanan_id);
            $("#no_pendaftaran").val(data.no_pendaftaran);
            $("#nama_pegawai").val(data.namalengkapdokter);
            $("#catatandokterpengirim").val(data.catatandokterpengirim);
            $("#tglmasukpenunjang").val(data.tglmasukpenunjang);
            $("#tgl_pendaftaran").val(data.tgl_pendaftaran);
            $("#instalasiasal_nama").val(data.instalasiasal_nama);
            $("#ruanganasal_nama").val(data.ruanganasal_nama);
            $("#jeniskasuspenyakit_nama").val(data.jeniskasuspenyakit_nama);
            $("#carabayar_nama").val(data.carabayar_nama);
            $("#penjamin_nama").val(data.penjamin_nama);
            $("#no_rekam_medik").val(data.no_rekam_medik);
            $("#namadepan").val(data.namadepan);
            $("#nama_pasien").val(data.nama_pasien);
            $("#nama_bin").val(data.nama_bin);
            $("#tanggal_lahir").val(data.tanggal_lahir);
            $("#umur").val(data.umur);
            $("#jeniskelamin").val(data.jeniskelamin);
            $("#nama_pj").val(data.nama_pj);
            $("#pengantar").val(data.pengantar);
            $("#kelaspelayanan_nama").val(data.kelaspelayanan_nama);
            $("#alamat_pasien").val(data.alamat_pasien);
            if(data.photopasien === null || data.photopasien === ""){ //set photo
                $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
            }else{
                $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
            }
            
            setPermintaanKePenunjang();
            //setTimeout(function(){setCheckedPemeriksaanDariPermintaan();}, 3000);//auto check permintaan
            //alert('asdasda');
            $("#form-datakunjungan > legend > .judul").html('Data Rujukan '+data.no_pendaftaran);
            $("#form-datakunjungan > legend > .tombol").attr('style','display:true;');
            $("#form-datakunjungan > .box").addClass("well").removeClass("box");
            
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#no_pendaftaran").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data rujukan tidak ditemukan!"); 
            console.log(errorThrown);
            setKunjunganReset();
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#no_pendaftaran").focus();
        }
    });

}
/**
 * untuk mereset form kunjungan
 * @returns {undefined} */
function setKunjunganReset(){
    $("#form-datakunjungan input,textarea").each(function(){
        $(this).val("");
    });
    $("#ruangan_id").val(<?php echo $modKunjungan->ruangan_id; ?>);
    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
    $("#form-datakunjungan > legend > .judul").html('Data Rujukan');
    $("#form-datakunjungan > legend > .tombol").attr('style','display:none;');
    $("#form-datakunjungan > .well").addClass("box").removeClass("well");
        
    $('#form-permintaankepenunjang table > tbody').html("");
    $('#form-tindakanpemeriksaan table > tbody').html("");
    $('#content-pemeriksaan-lab .checklists').html("");
    $('#content-pemeriksaan-lab input').each(function(){
        $(this).val("");
    });
}

/**
 * update (refresh) checklist pemeriksaan lab
 * harus include /js/jquery.tiler.js
 * @param {obj} form_checklist
 */
function updateChecklistPemeriksaanLab(){
    return false;
    console.log('testeteesssss');
    $('.checklists').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('/laboratorium/pendaftaranLaboratorium/SetChecklistPemeriksaanLab'); ?>',
        data: {data:$("#form-caripemeriksaan :input").serialize()},
        dataType: "json",
        success:function(data){
            console.log('konten: ' + data.content);
            $('.checklists').html(data.content);
            $('.checkboxlist-tile').tile({widths : [ 190 ]});
            $('.checklists').removeClass("animation-loading");
            setCheckedPemeriksaan($("#form-tindakanpemeriksaan"));

            if (is_permintaan) {
                is_permintaan = false;
                setCheckedPemeriksaanDariPermintaan();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
 * Set checklist pemeriksaan lab
 */
function setChecklistPemeriksaanLab(){
    var penjamin_id = $("#penjamin_id").val();
    var ruangan_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang,'ruangan_id') ?>").val();
    var kelaspelayanan_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang,'kelaspelayanan_id') ?>").val();
    if(penjamin_id == "" && kelaspelayanan_id==""){
        myAlert("Silakan pilih data rujukan!");
        setChecklistPemeriksaanLabReset();
    }else{
        $("#form-caripemeriksaan").find("input[name$='[ruangan_id]']").val(ruangan_id);
        $("#form-caripemeriksaan").find("input[name$='[penjamin_id]']").val(penjamin_id);
        $("#form-caripemeriksaan").find("input[name$='[kelaspelayanan_id]']").val(kelaspelayanan_id);
        updateChecklistPemeriksaanLab();
    }
}

/**
* hitung tarif tindakan RND-4168
*/ 
function hitungTotal(obj)
{   
    unformatNumberSemua();
    var qty = $(obj).val();
    var harga = parseFloat($(obj).parents('tr').find('input[name$="[tarif_satuan]"]').val());
    var subTotal=0;
    
    subTotal = parseFloat(harga*qty);
    if ($.isNumeric(subTotal)){
        $(obj).parents('tr').find('input[name$="[tarif_tindakan]"]').val(subTotal);
    }

    formatNumberSemua();
}

/**
 * reset pencarian & checklist pemeriksaan lab
 */
function setChecklistPemeriksaanLabReset(){
    $("#form-caripemeriksaan").find("input:not(:disabled):not([readonly])").each(function(){
        $(this).val("");
    });
    updateChecklistPemeriksaanLab();
}
/**
 * Centang pemeriksaan lab dari checkboxlist
 */
function pilihPemeriksaanIni(obj){
    var pemeriksaanlab_id = $(obj).val();
    var pemeriksaanlab_nama = $(obj).parent().find('input[name$="[pemeriksaanlab_nama]"]').val();
    var daftartindakan_id = $(obj).parent().find('input[name$="[daftartindakan_id]"]').val();
    var jenistarif_id = $(obj).parent().find('input[name$="[jenistarif_id]"]').val();
    var harga_tariftindakan = $(obj).parent().find('input[name$="[harga_tariftindakan]"]').val();
    var rowtindakan = [];
    rowtindakan = '<?php echo CJSON::encode($this->renderPartial($this->path_view_pendaftaran.'_rowTindakanPemeriksaan',array('i'=>0,'modTindakan'=>$modTindakan),true));?>';
    if($(obj).is(':checked')){
        $("#form-tindakanpemeriksaan").find('tbody').append(rowtindakan);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tindakanpelayanan_id]"]').val("");
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][pemeriksaanlab_id]"]').val(pemeriksaanlab_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][daftartindakan_id]"]').val(daftartindakan_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][jenistarif_id]"]').val(jenistarif_id);$("#form-tindakanpemeriksaan").find('span[name$="[ii][pemeriksaanlab_nama]"]').html(pemeriksaanlab_nama);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][satuantindakan]"]').val("<?php echo Params::SATUAN_TINDAKAN_LABORATORIUM; ?>");
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_satuan]"]').val(harga_tariftindakan);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_tindakan]"]').val(formatInteger(harga_tariftindakan));
        $("#form-tindakanpemeriksaan").find('a').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
    }else{
        var delete_row = $("#form-tindakanpemeriksaan").find('input[name$="[pemeriksaanlab_id]"][value="'+pemeriksaanlab_id+'"]').parents('tr');
        if(delete_row.find('input[name$="[tindakanpelayanan_id]"][value=""]').length > 0){
			delete_row.detach();
		}else{
			myAlert("Pemeriksaan tidak bisa dibatalkan karena sudah ditagihkan / dibayarkan ke pasien!");
			$(obj).attr("checked",true);
		}
    }
    renameInputRow($("#form-tindakanpemeriksaan"));
}
/**
 * rename input row yang terakhir di tambahkan
 * @param {type} obj_table
 */
function renameInputRow(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        console.log('tes masuk input');
        $(this).find("#no_urut").val(row+1);
        $(this).find('span').each(function(){ //element <span>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
            }
        });
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 4){
                $(this).attr("id",old_name_arr[0]+"_"+old_name_arr[1]+"_"+row+"_"+old_name_arr[3]);
                $(this).attr("name",old_name_arr[0]+"["+old_name_arr[1]+"]["+row+"]["+old_name_arr[3]+"]");
            }
        });
        row++;
    });
    
}
/**
 * set checked pemeriksaan yang sudah ada di daftar
 */
function setCheckedPemeriksaan(obj_table){
    $("div.checklists").find('input[name$="[is_pilih]"]').removeAttr('checked');
    $(obj_table).find('input[name$="[pemeriksaanlab_id]"]').each(function(){
        var pemeriksaanlab_id = $(this).val();
        $("div.checklists").find('input[name$="[is_pilih]"][value='+pemeriksaanlab_id+']').attr('checked',true);
    });
    
}
/**
 * set otomatis pilih pemeriksaan dari tabel permintaan ke penunjang 
 */
function setCheckedPemeriksaanDariPermintaan(){
    var carabayar = $('#carabayar_id').val();
    $('#form-tindakanpemeriksaan table > tbody').html("");
    setCheckedPemeriksaan($("#form-tindakanpemeriksaan"));
    $("#form-permintaankepenunjang").find('input[name$="[pemeriksaanlab_id]"]').each(function(){
        var pemeriksaanlab_id = $(this).val();
        var status_bayar = $(this).parents("tr").find(".status_bayar").html().trim();
        var tipepaket_id = $(this).parents("tr").find("input[name$='[tipepaket_id]']").val();
        var checkbox_pemeriksaan = $("div.checklists").find('input[name$="[is_pilih]"][value='+pemeriksaanlab_id+']');
        if (tipepaket_id == '<?= Params::TIPEPAKET_ID_NONPAKET ?>' || tipepaket_id == ''){
        
//        console.log("Pilih", pemeriksaanlab_id, status_bayar, checkbox_pemeriksaan);
        
            if(checkbox_pemeriksaan.val()){
                checkbox_pemeriksaan.prop('checked',true);
                //if (carabayar == 1 && status_bayar == "BELUM LUNAS") {
                //} else {
                pilihPemeriksaanIni(checkbox_pemeriksaan);
                //memindahkan tindakanpelayanan_id RND-6827
                var tindakanpelayanan_id = $(this).parents('tr').find('input[name$="[tindakanpelayanan_id]"]').val();
                var rowpermintaan = $("#form-tindakanpemeriksaan").find('input[name$="[pemeriksaanlab_id]"][value='+pemeriksaanlab_id+']');
                if(tindakanpelayanan_id > 0){
                    rowpermintaan.parents('tr').find('input[name$="[tindakanpelayanan_id]"]').val(tindakanpelayanan_id);
                    checkbox_pemeriksaan.prop('disabled', true);
                }
                //}
            
            }
        }else{
            setPemeriksaanPaket($(this));
        }
        //end memindahkan tindakanpelayanan_id
    });
}


function setPemeriksaanPaket(obj){
    var parents = $(obj).parents("tr");
    var pemeriksaanlab_id = $(obj).val();
    var pemeriksaanlab_nama = parents.find('span[name$="[pemeriksaanlab_nama]"]').html();
    var daftartindakan_id =parents.find('input[name$="[daftartindakan_id]"]').val();
    var jenistarif_id = parents.find('input[name$="[jenistarif_id]"]').val();
    var tarif_satuan = parents.find('input[name$="[tarif_satuan]"]').val();
    var tarif_tindakan = parents.find('input[name$="[tarif_tindakan]"]').val();
    var tindakanpelayanan_id = parents.find('input[name$="[tindakanpelayanan_id]"]').val();
    var satuantindakan = parents.find('input[name$="[satuantindakan]"]').val();
    var tindakansudahbayar_id = parents.find('input[name$="[tindakansudahbayar_id]"]').val();
    var qty_tindakan = parents.find('input[name$="[qty_tindakan]"]').val();
    
    var rowtindakan = [];
    rowtindakan = '<?php echo CJSON::encode($this->renderPartial($this->path_view_pendaftaran.'_rowTindakanPemeriksaan',array('i'=>0,'modTindakan'=>$modTindakan),true));?>';
    
    $("#form-tindakanpemeriksaan").find('tbody').append(rowtindakan);
    $("#form-tindakanpemeriksaan").find('input[name$="[ii][tindakanpelayanan_id]"]').val(tindakanpelayanan_id);
    $("#form-tindakanpemeriksaan").find('input[name$="[ii][pemeriksaanlab_id]"]').val(pemeriksaanlab_id);
    $("#form-tindakanpemeriksaan").find('input[name$="[ii][daftartindakan_id]"]').val(daftartindakan_id);
    $("#form-tindakanpemeriksaan").find('input[name$="[ii][jenistarif_id]"]').val(jenistarif_id);
    $("#form-tindakanpemeriksaan").find('span[name$="[ii][pemeriksaanlab_nama]"]').html(pemeriksaanlab_nama);
    $("#form-tindakanpemeriksaan").find('input[name$="[ii][satuantindakan]"]').val(satuantindakan);
    $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_satuan]"]').val(tarif_satuan);
    $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_tindakan]"]').val(tarif_tindakan);
    $("#form-tindakanpemeriksaan").find('input[name$="[ii][tindakansudahbayar_id]"]').val(tindakansudahbayar_id);
    $("#form-tindakanpemeriksaan").find('input[name$="[ii][qty_tindakan]"]').val(qty_tindakan);
    
    $("#form-tindakanpemeriksaan").find('a').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
    
    renameInputRow($("#form-tindakanpemeriksaan"));
    hitungTotal();
}

/**
 * bersihkan tabel tindakan pemeriksaan jika ada perubahan kelaspelayanan, ruangan 
 **/
function setTindakanPemeriksaanReset(){
    $("#form-tindakanpemeriksaan tbody").html("");
    setTimeout(function(){setCheckedPemeriksaanDariPermintaan();}, 3000);//auto check permintaan
}
/**
* load permintaan ke penunjang:
* - pasienkirimkeunitlain_id
*/ 

var is_permintaan = false;
function setPermintaanKePenunjang(){
    $('#form-permintaankepenunjang').addClass("animation-loading");
    var penjamin_id = $("#penjamin_id").val();
    var pasienkirimkeunitlain_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'pasienkirimkeunitlain_id')?>").val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetPermintaanKePenunjang'); ?>',
        data: {penjamin_id:penjamin_id, pasienkirimkeunitlain_id:pasienkirimkeunitlain_id, program:'<?=$_GET['program']?>'},
        dataType: "json",
        success:function(data){
            is_permintaan = true;
            $('#form-permintaankepenunjang table > tbody').html(data.rows);
            $('#form-permintaankepenunjang').removeClass("animation-loading");
            renameInputRowPenunjang($("#form-permintaankepenunjang"));
            
            $('#form-tindakanpemeriksaan table > tbody').html(data.rows_pemeriksaan);
            renameInputRow($("#form-tindakanpemeriksaan"));

            $("#form-tindakanpemeriksaan table > tbody tr").each(function() {
            //    setMultiSelectRow(this);
            });

            // setTimeout(() => {
                setOneRowJenis();
            // }, 500);
            
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function setOneRowJenis() {

    var isi_sblm = '';
    var rowspan = 1;
    var eq_beda = -1;
    var row_eq = [];

    $('.td-nourut').each(function (idx) {
        // var isi = $(this).closest('tr').find('.jenispemeriksaanlab_id').val();
        var isi = $(this).closest('tr').attr('class');

        console.log("-------------------------------------------------");
        console.log("eq beda: " + eq_beda);
        console.log("isi kelas: " + isi);
        console.log("nomor: " + $(this).val());
        console.log("isi beda: " + (isi == 'tr-beda'));
        console.log("isi sama: " + (isi == 'tr-sama'));
        console.log("-------------------------------------------------");

        if(isi == 'tr-beda') {
            if(eq_beda > -1) {
                row_eq.push([eq_beda, rowspan]);
            }
            eq_beda++;
            rowspan = 1;
        } else if(isi == 'tr-sama') {
            rowspan++;
            console.log("/////////////////////////");
            console.log("typeofnya: " + (typeof $(this).closest('tr').next('tr').html() == 'undefined'));
            if(typeof $(this).closest('tr').next('tr').html() !== "undefined") {
                
                if($(this).closest('tr').next('tr').hasClass("tr-beda")) {
                    // row_eq.push([eq_beda, rowspan]);
                }
            } else {
                row_eq.push([eq_beda, rowspan]);
                console.log("+++++++++++++++++++++++++");
                console.log("ini sama terakhir");
                console.log("+++++++++++++++++++++++++");
            }
        }


    });
  
    $('.tr-sama').each(function () {
        $(this).find('.td-nourut').addClass("hide");
        $(this).find('.td-nopel').addClass("hide");
        $(this).find('.td-jenis').addClass("hide");
        $(this).find('.td-sample').addClass("hide");
        $(this).find('.td-caraambil').addClass("hide");
        $(this).find('.td-hapus').addClass("hide");
    });

    $('.tr-beda').each(function (idx) {

        console.log("beda ke-" + idx);

        if(typeof row_eq[idx] !== 'undefined') {
        $(this).find('.td-nourut').attr('rowspan', row_eq[idx][1]);
        $(this).find('.td-nopel').attr('rowspan', row_eq[idx][1]);
        $(this).find('.td-jenis').attr('rowspan', row_eq[idx][1]);
        $(this).find('.td-sample').attr('rowspan', row_eq[idx][1]);
        $(this).find('.td-caraambil').attr('rowspan', row_eq[idx][1]);
        $(this).find('.td-hapus').attr('rowspan', row_eq[idx][1]);
        }
    });

    console.log("list kelompok 1: " + row_eq);


    var no = 0;

    $('.td-nourut').each(function () {
        if(!$(this).hasClass('hide')) {
            no++;
        }

        $(this).find('.nourut').val(no);

    });
}
/**
* load pemeriksaan yang sudah tersimpan berdasarkan:
* - pasienmasukpenunjang_id
*/ 
function setTindakanPelayanan(){
    $('#form-tindakanpemeriksaan').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetTindakanPelayanan'); ?>',
        data: {pasienmasukpenunjang_id:$("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'pasienmasukpenunjang_id')?>").val()},
        dataType: "json",
        success:function(data){
            $('#form-tindakanpemeriksaan table > tbody').html(data.rows);
            $('#form-tindakanpemeriksaan').removeClass("animation-loading");
            renameInputRow($("#form-tindakanpemeriksaan"));
            setChecklistPemeriksaanLab();

        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
 * menambahkan form obatalkespasien ke tabel
 * copy dari: laboratorium.views.pemakaianBmhp
 * @type Arguments
 */
function tambahObatAlkesPasien(obj)
{
    unformatNumberSemua();
    var pasienmasukpenunjang_id = $('#pasienmasukpenunjang_id').val();
    var obatalkes_id = $(obj).parents('#form-tambahobatalkes').find('#obatalkes_id').val();
    var obatalkes_kode = $(obj).parents('#form-tambahobatalkes').find('#obatalkes_kode').val();
    var obatalkes_nama = $(obj).parents('#form-tambahobatalkes').find('#obatalkes_nama').val();
    var jumlah = $(obj).parents('#form-tambahobatalkes').find('#qty_input').val();
    
    console.log("Kicker", obatalkes_id, jumlah, pasienmasukpenunjang_id);
    
    if((obatalkes_id!='') && (jumlah > 0)){
        
        
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
            data: {obatalkes_id:obatalkes_id,jumlah:jumlah},//
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    var params = [];
                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi:'Stok Obat Alkes Habis', isinotifikasi:obatalkes_kode+' '+obatalkes_nama+'  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16 
                    insert_notifikasi(params);
                    return false;
                }
                var tambahkandetail = true;
                var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
                if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
                    myConfirm('Apakah Anda akan input ulang obat ini?', 'Perhatian!', function(r)
                    {
                        if(r){
                            $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){
                                $(this).parents('tr').detach();
                            });
                        }
                        else{
                            tambahkandetail = false;
                        }
                    });
                }
                if(tambahkandetail){
                    $('#table-obatalkespasien > tbody').append(data.form);
                    $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
                    );
                    renameInputRowObatAlkes($("#table-obatalkespasien"));  
                }
                $(obj).parents('fieldset').find('#obatalkes_id').val('');
                $('#obatalkes_nama').val('');
                $('#qty_input').val(1);
                formatNumberSemua();
                renameInputRowObatAlkes($("#table-obatalkespasien")); 
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        if(pasienmasukpenunjang_id == ''){
            myAlert("Silakan isi data kunjungan terlebih dahulu!");
        }else if(obatalkes_id == ''){
            myAlert("Silakan pilih obat alkes terlebih dahulu!");
        }else if(jumlah == 0){
            myAlert("Stok obat kosong!");
        }
    }
    setObatAlkesPasienReset();  
}

//function tambahObatAlkesPasien(){
//    unformatNumberSemua();
//    var pasienmasukpenunjang_id = $('#pasienmasukpenunjang_id').val();
//    var obatalkes_id = $('#obatalkes_id').val();
//    var obatalkes_nama = $('#obatalkes_nama').val();
//    var satuankecil_id = $('#satuankecil_id').val();
//    var satuankecil_nama = $('#satuankecil_nama').val();
//    var sumberdana_id = $('#sumberdana_id').val();
//    var qty = parseInt($('#qty_input').val());
//    var qty_stok = parseInt($('#qty_stok').val());
//    var hargajual = parseInt($('#hargajual').val());
//    var harganetto = parseInt($('#harganetto').val());
//
//    var rowtindakan = "";
//    rowtindakan = '<?php // echo CJSON::encode($this->renderPartial('_rowObatAlkesPasien',array('modObatAlkesPasien'=>$modObatAlkesPasien),true));?>';
//    if((obatalkes_id!='') && (pasienmasukpenunjang_id!='') && (qty_stok > 0) && (qty <= qty_stok)){
//        $("#table-obatalkespasien").find('tbody').append(rowtindakan);
//        $("#table-obatalkespasien").find('input[name$="[ii][obatalkes_id]"]').val(obatalkes_id);
//        $("#table-obatalkespasien").find('span[name$="[ii][obatalkes_nama]"]').html(obatalkes_nama);
//        $("#table-obatalkespasien").find('span[name$="[ii][satuankecil_nama]"]').html(satuankecil_nama);
//        $("#table-obatalkespasien").find('input[name$="[ii][qty_stok]"]').val(qty_stok);
//        $("#table-obatalkespasien").find('input[name$="[ii][qty_oa]"]').val(qty);
//        $("#table-obatalkespasien").find('input[name$="[ii][hargajual_oa]"]').val(hargajual);
//        $("#table-obatalkespasien").find('input[name$="[ii][harganetto_oa]"]').val(harganetto);
//        $("#table-obatalkespasien").find('input[name$="[ii][sumberdana_id]"]').val(sumberdana_id);
//        $("#table-obatalkespasien").find('input[name$="[ii][satuankecil_id]"]').val(satuankecil_id);
//        $("#table-obatalkespasien").find('input[name$="[ii][iurbiaya]"]').val(qty*hargajual);
//        $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
//            {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
//        );
//        $('#table-obatalkespasien').find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
//        renameInputRowObatAlkes($("#table-obatalkespasien"));
//        formatNumberSemua();
//    }else{
//        if(pasienmasukpenunjang_id == ''){
//            myAlert("Silakan isi data kunjungan terlebih dahulu!");
//        }else if(obatalkes_id == ''){
//            myAlert("Silakan pilih obat alkes terlebih dahulu!");
//        }else if(qty_stok == 0){
//            myAlert("Stok obat kosong!");
//        }else if(qty > qty_stok){
//            myAlert("Jumlah tidak boleh lebih besar dari stok tersedia "+qty_stok+".");
//        }
//    }
//    setObatAlkesPasienReset();
//}

/**
 * reset form obat
 * copy dari: laboratorium.views.pemakaianBmhp
 */
function setObatAlkesPasienReset(){
    $('#form-tambahobatalkes :input').val("");
    $('#qty_input').val("1");
    $('#obatalkes_nama').focus();
}
/**
* load obatalkespasien_t yang sudah tersimpan berdasarkan:
* - pasienmasukpenunjang_id
* copy dari: laboratorium.views.pemakaianBmhp
*/ 
function setRiwayatObatAlkesPasien(){
    $('#riwayat-obatalkespasien-t').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('/laboratorium/PemakaianBahan/setRiwayatObatAlkesPasien'); ?>',
        data: {pasienmasukpenunjang_id:$("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'pasienmasukpenunjang_id') ?>").val()},
        dataType: "json",
        success:function(data){
            $('#riwayat-obatalkespasien-t table > tbody').html(data.rows);
            $('#riwayat-obatalkespasien-t table > tbody').find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
            $('#riwayat-obatalkespasien-t').removeClass("animation-loading");
            renameInputRowObatAlkes($("#riwayat-obatalkespasien-t"));
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/**
* rename input grid
* copy dari: laboratorium.views.pemakaianBmhp
*/ 
function renameInputRowObatAlkes(obj_table){
        var row = 0;
        $(obj_table).find("tbody > tr").each(function(){
            $(this).find("#no_urut").val(row+1);
            $(this).find('span').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 3){
                    $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
                }
            });
            $(this).find('input,select,textarea').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 3){
                    $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                    $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                }
            });
            row++;
        });
}
/**
 * membatalkan form input obat alkes pasien 
 * copy dari: laboratorium.views.pemakaianBmhp
 */ 
function batalOaPasien(obj)
{
    myConfirm('Apakah Anda akan membatalkan obat / alat kesehatan ini?', 'Perhatian!', function(r)
    {
        if(r){
            $(obj).parents('tr').remove();
            renameInputRowObatAlkes($("#table-obatalkespasien"));
        }
    });
}
/**
 * menghapus obat alkes pasien yang sudah tersimpan di ObatalkespasienT
 * berdasarkan obatalkespasien_id
 * copy dari: laboratorium.views.pemakaianBmhp
 */ 
function hapusOaPasien(obatalkespasien_id)
{
    myConfirm('Apakah Anda akan menghapus obat / alat kesehatan ini?', 'Perhatian!', function(r)
    {
        if(r){
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('/laboratorium/PemakaianBmhp/hapusObatAlkesPasien'); ?>',
                data: {obatalkespasien_id:obatalkespasien_id},
                dataType: "json",
                success:function(data){
                    if(data.sukses){
                        var delete_row = $("#riwayat-obatalkespasien-t").find('input[name$="[obatalkespasien_id]"][value="'+obatalkespasien_id+'"]').parents('tr');
                        delete_row.detach();
                        renameInputRowObatAlkes($("#riwayat-obatalkespasien-t"));
                    }
                    myAlert(data.pesan);
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
            renameInputRowObatAlkes($("#riwayat-obatalkespasien-t"));
        }
    });
}
/**
 * menghitung subtotal obat alkes per baris
 * copy dari: laboratorium.views.pemakaianBmhp
 */ 
function hitungSubTotal(obj)
{
    unformatNumberSemua();
    var subtotal = 0;
    var qty = parseInt($(obj).val());
    var qty_stok = parseInt($(obj).parents('tr').find('input[name$="[qty_stok]"]').val());
    var hargajual_oa = parseInt($(obj).parents('tr').find('input[name$="[hargajual_oa]"]').val());
    subtotal = qty * hargajual_oa;
    $(obj).parents('tr').find('input[name$="[iurbiaya]"]').val(formatInteger(subtotal));
    if(qty > qty_stok){
        $(obj).val(qty_stok);
        myAlert("Jumlah tidak boleh lebih besar dari stok!");
    }
    formatNumberSemua();
}

/**
* print pemakaian bahan
* copy dari: laboratorium.views.pemakaianBmhp
*/ 
function printPemakaianOa(pasienmasukpenunjang_id)
{
    window.open('<?php echo $this->createUrl('/laboratorium/PemakaianBahan/print'); ?>&pasienmasukpenunjang_id='+pasienmasukpenunjang_id,'printwin','left=100,top=100,width=480,height=640');
}

/**
 * print status 
 */
function printStatus()
{
    var pasienmasukpenunjang_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'pasienmasukpenunjang_id')?>").val();
    if(pasienmasukpenunjang_id != ""){
        window.open('<?php echo Yii::app()->createUrl('/rawatJalan/tindakan/printTindakanPenunjang'); ?>&pasienmasukpenunjang_id='+pasienmasukpenunjang_id,'printwin','left=100,top=100,width=720,height=640');
    }else{
        myAlert("Silakan pilih data rujukan pasien!");
    }
}

function setKarcis()
{
    var kelaspelayanan_id=$("#kelaspelayananasal_id").val();
    var penjamin_id=$("#penjamin_id").val();
    var pasien_id=$("#pasien_id").val();
    var pendaftaran_id=$("#pendaftaran_id").val();
    
    
    if(kelaspelayanan_id !== "" && pasien_id !== ""  && penjamin_id !== "") {		
        $("#form-karcis").addClass("animation-loading");
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetKarcis'); ?>',
            data: {
                kelaspelayanan_id:kelaspelayanan_id, 
                penjamin_id:penjamin_id, 
                pasien_id:pasien_id,
                pendaftaran_id:pendaftaran_id
            },//
            dataType: "json",
            success:function(data){
                $("#form-karcis #content-karcis-html").html(data.listKarcis);
                $("#form-karcis").removeClass("animation-loading");
            },
             error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        $("#content-karcis-html").html("");
    }
       
}

function cekHargaKelasPelayanan(obj) {
    var kelaspelayanan_id = $(obj).val();
    var permintaankepenunjang_id = $(obj).parents("tr").find(".permintaan_permintaankepenunjang_id").val();
    var daftartindakan_id = $(obj).parents("tr").find(".permintaan_daftartindakan_id").val();
    var pemeriksaanlab_id = $(obj).parents("tr").find(".permintaan_pemeriksaanlab_id").val();
    var jenistarif_id = $(obj).parents("tr").find(".permintaan_jenistarif_id").val();
    var qty = $(obj).parents("tr").find(".permintaan_qty_tindakan").val();

    // $(obj).parents("tr").find(".btn_permintaan_tambah").prop("disabled", true);
    $(obj).parents("tr").find(".row_permintaan_tarif").html(0);
    $(obj).parents("tr").find(".permintaan_tarif_satuan").val(0);
    $(obj).parents("tr").find(".permintaan_tarif_tindakan").val(0);

    $.post('<?php echo $this->createUrl('loadTarifTindakanUntukKelas'); ?>', {
        permintaankepenunjang_id: permintaankepenunjang_id, 
        kelaspelayanan_id: kelaspelayanan_id,
        daftartindakan_id: daftartindakan_id,
        pemeriksaanlab_id: pemeriksaanlab_id,
        jenistarif_id: jenistarif_id,
        qty: qty
    }, function(data) {
        if (data.nilai > 0) {
            $(obj).parents("tr").find(".permintaan_tarif_satuan").html(data.nilai_satuan);
            $(obj).parents("tr").find(".permintaan_tarif_tindakan").html(data.nilai);
            $(obj).parents("tr").find(".row_permintaan_tarif").html(data.nilai_format);
            $(obj).parents("tr").find(".btn_permintaan_tambah").prop("disabled", false);
        }
        
    }, 'json');
}

function tambahPeriksaPermintaan(obj) {
    var is_ditambahkan = $(obj).closest('td').find('.is_ditambahkan').val();
    var kelaspelayanan_id = $(obj).parents("tr").find(".permintaan_kelaspelayanan_id").val();
    var permintaankepenunjang_id = $(obj).parents("tr").find(".permintaan_permintaankepenunjang_id").val();
    var daftartindakan_id = $(obj).parents("tr").find(".permintaan_daftartindakan_id").val();
    var pemeriksaanlab_id = $(obj).parents("tr").find(".permintaan_pemeriksaanlab_id").val();
    var jenistarif_id = $(obj).parents("tr").find(".permintaan_jenistarif_id").val();
    var qty = $(obj).parents("tr").find(".permintaan_qty_tindakan").val();

    console.log('kelaspelayanan_id: ' + kelaspelayanan_id);
    console.log('permintaankepenunjang_id: ' + permintaankepenunjang_id);
    console.log('daftartindakan_id: ' + daftartindakan_id);
    console.log('pemeriksaanlab_id: ' + pemeriksaanlab_id);
    console.log('jenistarif_id: ' + jenistarif_id);
    console.log('qty: ' + qty);

    if(is_ditambahkan) {
        myAlert('Pemeriksaan sudah ditambahkan');
    } else {
        $.post('<?php echo $this->createUrl('setFormTindakanDariPermintaan0'); ?>', {
        permintaankepenunjang_id: permintaankepenunjang_id, 
        kelaspelayanan_id: kelaspelayanan_id,
        daftartindakan_id: daftartindakan_id,
        pemeriksaanlab_id: pemeriksaanlab_id,
        jenistarif_id: jenistarif_id,
        qty: qty
    }, function(data) {
       
        $('#form-tindakanpemeriksaan table > tbody').append(data.rows);
        renameInputRow($("#form-tindakanpemeriksaan"));
        $(obj).closest('td').find('.is_ditambahkan').val(true);
        $(obj).closest('tr').addClass('hide');
        
    }, 'json');


    }
    
}

function setMultiSelectRow(row) {
    jQuery(row).find(".row_samplelab_id").multiselect({
        includeSelectAllOption: false,
        buttonClass: "form-control",
        maxHeight: 300,
        buttonWidth: '130px',
        enableCaseInsensitiveFiltering: true
    }).hide();

    jQuery(row).find(".row_caraambilsampel_id").multiselect({
        includeSelectAllOption: false,
        buttonClass: "form-control",
        maxHeight: 300,
        buttonWidth: '130px',
        enableCaseInsensitiveFiltering: true
    }).hide();
}

/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){
    <?php if(!$modPasienMasukPenunjang->isNewRecord){ ?>
        setTindakanPelayanan();
        setRiwayatObatAlkesPasien();
        $("input, select, textarea").attr("readonly",true);
    <?php } ?>
    <?php if(isset($_GET['pasienkirimkeunitlain_id'])){ ?>
        setPermintaanKePenunjang();
        //setTimeout(function(){setCheckedPemeriksaanDariPermintaan();}, 3000);//auto check permintaan
        setKarcis();
        $("#form-datakunjungan :input").attr("readonly",true);
        $("#form-datakunjungan .add-on").remove();
    <?php } ?>
    <?php if(isset($_GET['pendaftaran_id'])){ ?>
        setChecklistPemeriksaanLab();
        $("#form-datakunjungan :input").attr("readonly",true);
        $("#form-datakunjungan .add-on").remove();
    <?php } ?>

    // Notifikasi Pasien
    <?php 
	if(Yii::app()->user->getState('issmsgateway')){
        if(isset($_GET['smspasien'])){
            if($_GET['smspasien']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $modPasienMasukPenunjang->pasien->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
	}
    ?>  

    console.log('setRow ini ya');

    setTimeout(() => {
        setOneRowJenis();
    }, 5000);
});
</script>