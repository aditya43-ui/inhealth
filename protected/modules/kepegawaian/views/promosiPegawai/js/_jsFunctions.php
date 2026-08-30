<?php
/**
*       - digunakan untuk menyimpan semua fungsi javascript agar mudah ditracking utnuk di transaksi
*       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*       @website	<piindonesia.co.id>
*/
?>
<script>

function setDataPegawai(params){
$("#form-pegawai > div").addClass("animation-loading");
$.ajax({
    type:'POST',
    url:"<?php echo $this->createUrl('/kepegawaian/PromosiPegawai/getDataPegawai');?>",
    data: {idPegawai:params},
    dataType: "json",
    success:function(data){
        $("#nomorindukpegawai").val(data.nomorindukpegawai);
        $("#pegawai_id").val(data.pegawai_id);
        $("#namapegawai").val(data.nama_pegawai);
        $("#tempatlahir_pegawai").val(data.tempatlahir_pegawai);
        $("#tgl_lahirpegawai").val(data.tgl_lahirpegawai);
        $("#jabatan").val(data.jabatan_nama);
        $("#jeniskelamin").val(data.jeniskelamin);
        $("#statusperkawinan").val(data.statusperkawinan);
        $("#alamat_pegawai").val(data.alamat_pegawai);
        if(data.photopegawai != ""){
            var url = "<?php echo Params::urlPegawaiTumbsDirectory() . 'kecil_'; ?>" + data.photopegawai;
            $("#photo_pasien").attr('src', url);
        } else {
            var url = "<?php echo Params::urlPegawaiDirectory() . 'no_photo.jpeg'; ?>";
            $("#photo_pasien").attr('src',url);
        }  
		        
        $("#<?php echo CHtml::activeId($model, 'prom_jabatan_lama') ?>").val(data.jabatan_nama);
        $("#<?php echo CHtml::activeId($model, 'prom_golongan_lama') ?>").val(data.golonganpegawai_nama);
        $("#<?php echo CHtml::activeId($model, 'prom_pangkat_lama') ?>").val(data.pangkat_nama);
        $("#<?php echo CHtml::activeId($model, 'pegawai_id') ?>").val(data.pegawai_id);
        
        $("#form-pegawai > .panel-heading > .panel-title > .judul").html('Data Pegawai <b>'+data.nomorindukpegawai+'</b>');
        $("#form-pegawai > .panel-heading > .panel-title > .tombol").attr('style','display:true;');
        $("#form-pegawai > .panel-body").addClass("well").removeClass("box");
        
        $("#form-pegawai > div").removeClass("animation-loading");
        $("#nomorindukpegawai").focus();
    },
    error: function (jqXHR, textStatus, errorThrown) { 
        myAlert("Data pegawai tidak ditemukan!"); 
        console.log(errorThrown);
        setPegawaiReset();
        $("#form-pegawai > div").removeClass("animation-loading");
        $("#nomorindukpegawai").focus();
    }
});
}

function setPegawaiReset(){
    $("#nomorindukpegawai").val("");
    $("#pegawai_id").val("");
    $("#namapegawai").val("");
    $("#tempatlahir_pegawai").val("");
    $("#tgl_lahirpegawai").val("");
    $("#jabatan").val("");
    $("#jeniskelamin").val("");
    $("#statusperkawinan").val("");
    $("#alamat_pegawai").val("");
    var url = "<?php echo Params::urlPegawaiDirectory() . 'no_photo.jpeg'; ?>";
    $("#photo_pasien").attr('src',url);
    $("#form-pegawai  > .panel-heading > .panel-title > .judul").html('Data Pegawai');
    $("#form-pegawai  > .panel-heading > .panel-title > .tombol").attr('style','display:none;');
    $("#form-pegawai > .well").addClass("box").removeClass("well");
    $("#form-pegawai > div").removeClass("animation-loading");
    $("#nomorindukpegawai").focus();
}    

</script>