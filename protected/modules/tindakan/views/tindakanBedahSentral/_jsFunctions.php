<script type="text/javascript">
/**
 * set form kunjungan
 * @param {type} pasien_id
 * @returns {undefined}
 */
function setKunjungan(pendaftaran_id){
    $("#form-datakunjungan > div").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataKunjungan'); ?>',
        data: {pendaftaran_id:pendaftaran_id},
        dataType: "json",
        success:function(data){
//            $("#<?php // echo CHtml::activeId($modPendaftaran, 'pasienkirimkeunitlain_id')?>").val(data.pasienkirimkeunitlain_id);
            $("#<?php echo CHtml::activeId($modPendaftaran, 'jeniskasuspenyakit_id')?>").val(data.jeniskasuspenyakit_id);
            $("#<?php echo CHtml::activeId($modPendaftaran, 'kelaspelayanan_id')?>").val(data.kelaspelayanan_id);
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
            $("#tglmasukpenunjang").val(data.tglmasukpenunjang);
            $("#tgl_pendaftaran").val(data.tgl_pendaftaran);
            $("#instalasiasal_nama").val(data.instalasiasal_nama);
            $("#ruanganasal_nama").val(data.ruanganasal_nama);
            $("#nama_pegawai").val(data.namalengkapdokter);
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
            $("#instalasi_nama").val(data.instalasi_nama);
            $("#ruangan_nama").val(data.ruangan_nama);
            $("#nama_bin").val(data.nama_bin);
			$("#ruangan_id").val(data.ruangan_id);
			$("#instalasi_id").val(data.instalasi_id);
            if(data.photopasien === null || data.photopasien === ""){ //set photo
                $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
            }else{
                $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
            }
            
			setChecklistPemeriksaanBedahReset();
//            setPermintaanKePenunjang();
//            setTimeout(function(){setCheckedPemeriksaanDariPermintaan();}, 3000);//auto check permintaan
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
    $('#content-pemeriksaan-bedah .checklists').html("");
    $('#content-pemeriksaan-bedah input').each(function(){
        $(this).val("");
    });
}
/**
* hitung tarif tindakan RND-4169
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
 * update (refresh) checklist pemeriksaan bedah
 * harus include /js/jquery.tiler.js
 * @param {obj} form_checklist
 */
function updateChecklistPemeriksaanBedah(){
	var sukses = '<?= isset($_GET['sukses'])?1:0; ?>';
    $('#content-pemeriksaan-bedah .checklists').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetChecklistPemeriksaanBedah'); ?>',
        data: {data:$("#form-caripemeriksaan :input").serialize(),sukses:sukses},
        dataType: "json",
        success:function(data){
            $('#content-pemeriksaan-bedah .checklists').html(data.content);
            $('.checkboxlist-tile').tile({widths : [ 306 ]});
            $('#content-pemeriksaan-bedah .checklists').removeClass("animation-loading");
            setCheckedPemeriksaan($("#form-tindakanpemeriksaan"));
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
 * Set checklist pemeriksaan bedah
 */
function setChecklistPemeriksaanBedah(){
    var penjamin_id = $("#penjamin_id").val();
    var ruangan_id = $("#<?php echo CHtml::activeId($modPendaftaran,'ruangan_id') ?>").val();
    var kelaspelayanan_id = $("#<?php echo CHtml::activeId($modPendaftaran,'kelaspelayanan_id') ?>").val();
//    if(penjamin_id == "" && kelaspelayanan_id==""){
//        myAlert("Silakan pilih data rujukan!");
//        setChecklistPemeriksaanBedahReset();
//    }else{
        $("#form-caripemeriksaan").find("input[name$='[ruangan_id]']").val(ruangan_id);
        $("#form-caripemeriksaan").find("input[name$='[penjamin_id]']").val(penjamin_id);
        $("#form-caripemeriksaan").find("input[name$='[kelaspelayanan_id]']").val(kelaspelayanan_id);
        updateChecklistPemeriksaanBedah();
//    }
}
/**
 * reset pencarian & checklist pemeriksaan bedah
 */
function setChecklistPemeriksaanBedahReset(){
    $("#form-caripemeriksaan").find("input:not(:disabled):not([readonly])").each(function(){
        $(this).val("");
    });
    updateChecklistPemeriksaanBedah();
}
/**
 * Centang pemeriksaan bedah dari checkboxlist
 */
function pilihPemeriksaanIni(obj){
    var operasi_id = $(obj).val();
    var operasi_nama = $(obj).parent().find('input[name$="[operasi_nama]"]').val();
    var daftartindakan_id = $(obj).parent().find('input[name$="[daftartindakan_id]"]').val();
    var jenistarif_id = $(obj).parent().find('input[name$="[jenistarif_id]"]').val();
    var hargaoperasi = $(obj).parent().find('input[name$="[hargaoperasi]"]').val();
    var rowtindakan = [];
    rowtindakan = '<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowTindakanPemeriksaan',array('i'=>0,'modTindakan'=>$modTindakanDetail),true));?>';
    if($(obj).is(':checked')){
        $("#form-tindakanpemeriksaan").find('tbody').append(rowtindakan);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tindakanpelayanan_id]"]').val("");
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][operasi_id]"]').val(operasi_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][daftartindakan_id]"]').val(daftartindakan_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][jenistarif_id]"]').val(jenistarif_id);$("#form-tindakanpemeriksaan").find('span[name$="[ii][operasi_nama]"]').html(operasi_nama);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][satuantindakan]"]').val("<?php echo Params::SATUAN_TINDAKAN_LABORATORIUM; ?>");
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_satuan]"]').val(formatInteger(hargaoperasi));
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_tindakan]"]').val(formatInteger(hargaoperasi));
        $("#form-tindakanpemeriksaan").find('a').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
	}else{
        var delete_row = $("#form-tindakanpemeriksaan").find('input[name$="[daftartindakan_id]"][value="'+daftartindakan_id+'"]').parents('tr');
        delete_row.detach();
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
        $(this).find("#no_urut").val(row+1);
        $(this).find('span[name*="[ii]"]').each(function(){ //element <span>
            var new_name = $(this).attr("name").replace("ii",(row));
            $(this).attr("name",new_name);
        });
        $(this).find('span[name$="[operasi_nama]"]').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 2){
                $(this).attr("name","["+row+"]["+old_name_arr[1]+"]");
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
 * set checked pemeriksaan yang sudah ada di daftar
 */
function setCheckedPemeriksaan(obj_table){
    $("div.checklists").find('input[name$="[is_pilih]"]').removeAttr('checked');
    $(obj_table).find('input[name$="[operasi_id]"]').each(function(){
        var operasi_id = $(this).val();
        $("div.checklists").find('input[name$="[is_pilih]"][value='+operasi_id+']').attr('checked',true);
    });
    
}

function setCheckedTindakanOperasi(){
    $('#form-tindakanpemeriksaan table > tbody').html("");
    setCheckedPemeriksaan($("#form-tindakanpemeriksaan"));
    $("#form-permintaankepenunjang").find('input[name$="[operasi_id]"]').each(function(){
        var operasi_id = $(this).val();
        var checkbox_pemeriksaan = $("div.checklists").find('input[name$="[is_pilih]"][value='+operasi_id+']');
        checkbox_pemeriksaan.attr('checked',true);
        pilihPemeriksaanIni(checkbox_pemeriksaan);
    });
}
/**
 * bersihkan tabel tindakan pemeriksaan jika ada perubahan kelaspelayanan, ruangan 
 **/
function setTindakanPemeriksaanReset(){
    $("#form-tindakanpemeriksaan table > tbody").html("");
//    setTimeout(function(){setCheckedPemeriksaanDariPermintaan();}, 3000);//auto check permintaan
}

/**
* load pemeriksaan yang sudah tersimpan berdasarkan:
* - pasienmasukpenunjang_id
*/ 
function setRencanaTindakanOperasi(){
    $('#form-tindakanpemeriksaan').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetRencanaTindakanOperasi'); ?>',
        data: {pasienmasukpenunjang_id:$("#<?php echo CHtml::activeId($modPendaftaran, 'pasienmasukpenunjang_id')?>").val()},
        dataType: "json",
        success:function(data){
            $('#form-tindakanpemeriksaan table > tbody').html(data.rows);
            $('#form-tindakanpemeriksaan').removeClass("animation-loading");
            renameInputRow($("#form-tindakanpemeriksaan"));
            setChecklistPemeriksaanBedah();

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
    var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
    var obatalkes_kode = $(obj).parents('fieldset').find('#obatalkes_kode').val();
    var obatalkes_nama = $(obj).parents('fieldset').find('#obatalkes_nama').val();
    var jumlah = $(obj).parents('fieldset').find('#qty_input').val();
    
    if((obatalkes_id!='') && (pasienmasukpenunjang_id!='') && (jumlah > 0)){
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

function setTindakan(obj,label)
{
	if($(obj).is(':checked'))
	{
		var operasi_id = $(obj).val();
		var operasi_nama = label;
		tambahTindakanPemakaianBahan(operasi_id,operasi_nama);
	}
}

function tambahTindakanPemakaianBahan(value,label)
{
    $('#daftartindakanPemakaianBahan').append('<option value="'+value+'">'+label+'</option>');
}

/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){
	setTimeout(function(){setChecklistPemeriksaanBedah();}, 2000);

    // Notifikasi Pasien
    <?php 
        if(isset($_GET['smspasien'])){
            if($_GET['smspasien']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $modKunjungan->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>
});
</script>