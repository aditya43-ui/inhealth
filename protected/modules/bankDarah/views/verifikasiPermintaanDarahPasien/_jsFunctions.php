<script type="text/javascript">
/**
 * set form kunjungan
 * @param {type} pasien_id
 * @returns {undefined}
 */
$(function(){
    $('.jumlahkantong').css('cursor', 'pointer');
    $('.diambil').css('cursor', 'pointer');
    $('.dititip').css('cursor', 'pointer');
});

function ubahPencatatanStok(obj, permintaankepenunjang_id) {
    var jumlahkantong = $(obj).parents('tr').find('.jumlahkantong').val();
    var diambil = $(obj).parents('tr').find('.diambil').val();
    var dititip = $(obj).parents('tr').find('.dititip').val();
    var jenisvolumjumlahkantong = $(obj).parents('tr').find('.jenisvolumejumlahkantong').val();
    var jenisvolumedititip = $(obj).parents('tr').find('.jenisvolumedititip').val();
    var jenisvolumediambil = $(obj).parents('tr').find('.jenisvolumediambil').val();
    $('#form-permintaankepenunjang').addClass('animation-loading');
    $('#content-pencatatan-stok').addClass('animation-loading');
    $.post('<?= $this->createUrl('UbahPencatatanStok') ?>', {
        permintaankepenunjang_id:permintaankepenunjang_id,
        jumlahkantong:jumlahkantong,
        diambil:diambil,
        dititip:dititip,
        jenisvolumjumlahkantong:jenisvolumjumlahkantong,
        jenisvolumediambil:jenisvolumediambil,
        jenisvolumedititip:jenisvolumedititip
    }, function(data){
        if(data.sukses == 1) {
            toastr.success('Berhasil Merubah Data');
        } else {
            toastr.error('Gagal Merubah Data');
        }
        $('#form-permintaankepenunjang').find('table tbody').html(data.html);
        $('#content-pencatatan-stok').find('table tbody').html(data.htmlPencatatanStok);
        $('#form-permintaankepenunjang').removeClass('animation-loading');
        $('#content-pencatatan-stok').removeClass('animation-loading');
    }, 'json');
}

function enableInput(obj) {
    $(obj).parents('tr').find('.diambil, .dititip, .jumlahkantong').attr('readonly', false);
    $(obj).parents('tr').find('.jenisvolumejumlahkantong, .jenisvolumedititip, .jenisvolumediambil').attr('disabled', false);
    $(obj).addClass('hide');
    $(obj).parents('tr').find('.simpanPencatatan').removeClass('hide');
}

function batalTindakan(obj){
    myConfirm("Apakah Anda akan membatalkan tindakan pemeriksaan ini?","Perhatian!",
    function(r){
        if(r){
            $(obj).parents('tr').detach();
        }
    }); 
}


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
            $("#nama_pegawai").val(data.nama_pegawai);
            $("#catatandokterpengirim").val(data.catatandokterpengirim);
            $("#alamat_pasien").val(data.alamat_pasien);
            if(data.photopasien === null || data.photopasien === ""){ //set photo
                $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
            }else{
                $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
            }
            
            // setPermintaanKePenunjang();
            setTimeout(function(){setCheckedPemeriksaanDariPermintaan();}, 3000);//auto check permintaan
            
            $("#form-datakunjungan > legend > .judul").html('Data Rujukan '+data.no_pendaftaran);
            $("#form-datakunjungan > legend > .tombol").attr('style','display:true;');
            $("#form-datakunjungan > .box").addClass("well").removeClass("box");
            cekDisabled('form'); 
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
    $('#content-pemeriksaan-rehab .checklists').html("");
    $('#content-pemeriksaan-rehab input').each(function(){
        $(this).val("");
    });
}

/**
 * update (refresh) checklist pemeriksaan rehab medis
 * harus include /js/jquery.tiler.js
 * @param {obj} form_checklist
 */
function updateChecklistPemeriksaanRehab(){
    $('#content-pemeriksaan-rehab .checklists').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetChecklistPemeriksaanRehab'); ?>',
        data: {data:$("#form-caripemeriksaan :input").serialize()},
        dataType: "json",
        success:function(data){
            $('#content-pemeriksaan-rehab .checklists').html(data.content);
            $('.checkboxlist-tile').tile({widths : [ 256 ]});
            $('#content-pemeriksaan-rehab .checklists').removeClass("animation-loading");
            setCheckedPemeriksaan($("#form-tindakanpemeriksaan"));
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
 * Set checklist pemeriksaan rehabilitasi medis
 */
function setChecklistPemeriksaanRehab(){
    var penjamin_id = $("#penjamin_id").val();
    var ruangan_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang,'ruangan_id') ?>").val();
    var kelaspelayanan_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang,'kelaspelayanan_id') ?>").val();
    if(penjamin_id == "" && kelaspelayanan_id==""){
        myAlert("Silakan pilih data rujukan!");
        setChecklistPemeriksaanRehabReset();
    }else{
        $("#form-caripemeriksaan").find("input[name$='[ruangan_id]']").val(ruangan_id);
        $("#form-caripemeriksaan").find("input[name$='[penjamin_id]']").val(penjamin_id);
        $("#form-caripemeriksaan").find("input[name$='[kelaspelayanan_id]']").val(kelaspelayanan_id);
        updateChecklistPemeriksaanRehab();
    }
}
/**
 * reset pencarian & checklist pemeriksaan rehab medis
 */
function setChecklistPemeriksaanRehabReset(){
    $("#form-caripemeriksaan").find("input:not(:disabled):not([readonly])").each(function(){
        $(this).val("");
    });
    updateChecklistPemeriksaanRehab();
}
/**
 * Centang pemeriksaan rehab medis dari checkboxlist
 */
function pilihPemeriksaanIni(obj){
    var tindakanrm_id = $(obj).val();
    var jenistindakanrm_id = $(obj).parent().find('input[name$="[jenistindakanrm_id]"]').val();
    var jenistindakanrm_nama = $(obj).parent().find('input[name$="[jenistindakanrm_nama]"]').val();
    var tindakanrm_nama = $(obj).parent().find('input[name$="[tindakanrm_nama]"]').val();
    var daftartindakan_id = $(obj).parent().find('input[name$="[daftartindakan_id]"]').val();
    var jenistarif_id = $(obj).parent().find('input[name$="[jenistarif_id]"]').val();
    var harga_tariftindakan = $(obj).parent().find('input[name$="[harga_tariftindakan]"]').val();
    var rowtindakan = [];
    rowtindakan = '<?php echo CJSON::encode($this->renderPartial($this->path_view_pendaftaran.'_rowTindakanPemeriksaan',array('i'=>0,'modTindakan'=>$modTindakan),true));?>';
    console.log($(obj).is(':checked'));
    if($(obj).is(':checked')){
        $("#form-tindakanpemeriksaan").find('tbody').append(rowtindakan);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tindakanpelayanan_id]"]').val("");
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tindakanrm_id]"]').val(tindakanrm_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][jenistindakanrm_id]"]').val(jenistindakanrm_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][daftartindakan_id]"]').val(daftartindakan_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][jenistarif_id]"]').val(jenistarif_id);$("#form-tindakanpemeriksaan").find('span[name$="[ii][tindakanrm_nama]"]').html(tindakanrm_nama);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][satuantindakan]"]').val("<?php echo Params::SATUAN_TINDAKAN_LABORATORIUM; ?>");
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_satuan]"]').val(harga_tariftindakan);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_tindakan]"]').val(formatInteger(harga_tariftindakan));
        $("#form-tindakanpemeriksaan").find('a').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
    }else{
        var delete_row = $("#form-tindakanpemeriksaan").find('input[name$="[tindakanrm_id]"][value="'+tindakanrm_id+'"]').parents('tr');
        delete_row.detach();
    }
    renameInputRow($("#form-tindakanpemeriksaan"));
}

function hitungTarif(obj) {
    var qty_tindakan = $(obj).val();

    var totaltarif = $(obj).parents('tr').find('input[name$="[tarif_satuan]"]').val();

    console.log(qty_tindakan * totaltarif)
    $(obj).parents('tr').find('input[name$="[tarif_tindakan]"]').val(formatInteger(qty_tindakan * totaltarif));
}

function pilihPemeriksaanTindakanIni(obj, daftartindakan){
    console.log('this is')
    var tindakansudah_dipilih = 0;
    $("#form-tindakanpemeriksaan").find("tbody > tr").each(function(){
        if(daftartindakan == $(this).find('input[name$="[daftartindakan_id]"]').val()) {
            tindakansudah_dipilih += 1;
        }
    });

    var daftartindakan_nama = $(obj).closest('tr').find('.daftartindakan_nama').val();
    var daftartindakan_id = $(obj).closest('tr').find('.daftartindakan_id').val();
    var jenistarif_id = $(obj).closest('tr').find('.jenistarif_id').val();
    var harga_tariftindakan = $(obj).closest('tr').find('.harga_tariftindakan').val();
    var satuantindakan = $(obj).closest('tr').find('.satuantindakan').val("<?php echo Params::SATUAN_TINDAKAN_LABORATORIUM; ?>");
    var rowtindakan = [];
    rowtindakan = '<?php echo CJSON::encode($this->renderPartial('_rowTindakanPemeriksaan',array('i'=>0,'modTindakan'=>$modTindakan),true));?>';
    console.log($(obj).is(':checked'));
    if(tindakansudah_dipilih < 1) {
        $("#form-tindakanpemeriksaan").find('tbody').append(rowtindakan);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tindakanpelayanan_id]"]').val("");
        
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][daftartindakan_id]"]').val(daftartindakan_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][jenistarif_id]"]').val(jenistarif_id);$("#form-tindakanpemeriksaan").find('span[name$="[ii][daftartindakan_nama]"]').html(daftartindakan_nama);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_satuan]"]').val(harga_tariftindakan);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_tindakan]"]').val(formatInteger(harga_tariftindakan));
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][satuantindakan]"]').val(satuantindakan);
        $("#form-tindakanpemeriksaan").find('a').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
       
        
        renameInputRow($("#form-tindakanpemeriksaan"));
    } else {
        myAlert('Pemeriksaan Sudah Dipilih');
    }
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
        $(this).find('span[name$="[daftartindakan_nama]"]').each(function(){ //element <input>
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
    $(obj_table).find('input[name$="[tindakanrm_id]"]').each(function(){
        var tindakanrm_id = $(this).val();
        $("div.checklists").find('input[name$="[is_pilih]"][value='+tindakanrm_id+']').attr('checked',true);
    });
    
}
/**
 * set otomatis pilih pemeriksaan dari tabel permintaan ke penunjang 
 */
function setCheckedPemeriksaanDariPermintaan(){
    var jumlahtr = $("#form-tindakanpemeriksaan table tr").length;
    var pasienkirimkeunitlain_id = "<?= isset($_GET['pasienkirimkeunitlain_id']) ? $_GET['pasienkirimkeunitlain_id'] : null ?>";
    $.post('<?= $this->createUrl('SalinPemeriksaanDariPermintaan') ?>', {
        pasienkirimkeunitlain_id:pasienkirimkeunitlain_id,
        jumlahtr:jumlahtr
    }, function(data) {
        if(data.sukses == 1) {
            // var trSebelum = $("#form-permintaankepenunjang table tbody tr").clone();
            $('#form-tindakanpemeriksaan table > tbody').append(data.html);
        } else {
            myAlert('Ada Kesalahan Saat Mengambil Data [js]');
        }
    }, 'json');
    // $("#form-permintaankepenunjang table tbody tr").each(function(){
    //     var clonedRow = $(this).clone();

    //     clonedRow.find('.tarif').removeClass('hide');


    //     // Hapus <td> terakhir dari baris terklon
    //     clonedRow.find('td:last').remove();

    //     clonedRow.append('<td><a onclick="batalTindakan(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan tindakan"><i class="icon-form-silang"></i></a></td>');
        
    //     // Gantikan konten <td> terakhir dengan konten baru

    //     $('#form-tindakanpemeriksaan table > tbody').append(clonedRow);
    // });


}
/**
 * bersihkan tabel tindakan pemeriksaan jika ada perubahan kelaspelayanan, ruangan 
 **/
function setTindakanPemeriksaanReset(){
    $("#form-tindakanpemeriksaan table > tbody").html("");
    setTimeout(function(){setCheckedPemeriksaanDariPermintaan();}, 3000);//auto check permintaan
}
/**
* load permintaan ke penunjang:
* - pasienkirimkeunitlain_id
*/ 
function setPermintaanKePenunjang(){
    $('#form-permintaankepenunjang').addClass("animation-loading");
    var penjamin_id = $("#penjamin_id").val();
    var pasienkirimkeunitlain_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'pasienkirimkeunitlain_id')?>").val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetPermintaanKePenunjang'); ?>',
        data: {penjamin_id:penjamin_id, pasienkirimkeunitlain_id:pasienkirimkeunitlain_id},
        dataType: "json",
        success:function(data){
            $('#form-permintaankepenunjang table > tbody').html(data.rows);
            $('#form-permintaankepenunjang').removeClass("animation-loading");
            renameInputRow($("#form-permintaankepenunjang"));
            setChecklistPemeriksaanRehab();

        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/**
* load pemeriksaan yang sudah tersimpan berdasarkan:
* - pasienmasukpenunjang_id
*/ 
function setTindakanPelayanan(){

    var penunjang_id = "<?php echo $modPasienMasukPenunjang->pasienmasukpenunjang_id; ?>";


    $('#form-tindakanpemeriksaan').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetTindakanPelayanan'); ?>',
        data: {pasienmasukpenunjang_id:penunjang_id},
        dataType: "json",
        success:function(data){
            $('#form-tindakanpemeriksaan table > tbody').html(data.rows);
            $('#form-tindakanpemeriksaan').removeClass("animation-loading");
            renameInputRow($("#form-tindakanpemeriksaan"));
            setChecklistPemeriksaanRehab();

        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/**
 * print status 
 */
function printStatus()
{
    var pendaftaran_id = $("#pendaftaran_id").val();
    if(pendaftaran_id != ""){
        window.open('<?php echo $this->createUrl('pendaftaranRehabilitasiMedis/printStatusRehabMedis'); ?>&pendaftaran_id='+pendaftaran_id,'printwin','left=100,top=100,width=480,height=640');
    }else{
        myAlert("Silakan pilih data rujukan pasien!");
    }
}

/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){
    <?php if(!$modPasienMasukPenunjang->isNewRecord){ ?>
        setTindakanPelayanan();
        $("input, select, textarea").attr("readonly",true);
    <?php } ?>
    <?php if(isset($_GET['pasienkirimkeunitlain_id'])){ ?>
        // setPermintaanKePenunjang();
        //setTimeout(function(){setCheckedPemeriksaanDariPermintaan();}, 3000);//auto check permintaan
    <?php } ?>

    // Notifikasi Pasien
    <?php 
        if(isset($_GET['smspasien'])){
            if($_GET['smspasien']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $modKunjungan->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16 
        simpanNotifikasi(params);
    <?php            
            }
        }
    ?>
    // Notifikasi Dokter
    <?php 
        if(isset($_GET['smsdokter'])){
            if($_GET['smsdokter']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS DOKTER', isinotifikasi:'dr. <?php echo $modKunjungan->nama_pegawai; ?> tidak memiliki nomor mobile'}; // 16 
        simpanNotifikasi(params);
    <?php            
            }
        }
    ?>
    // Notifikasi Penanggungjawab
    <?php 
        if(isset($_GET['smspenanggungjawab'])){
            if($_GET['smspenanggungjawab']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PENANGGUNG JAWAB', isinotifikasi:'Penanggung jawab pasien <?php echo $modKunjungan->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16 
        simpanNotifikasi(params);
    <?php            
            }
        }
    ?>
});
</script>