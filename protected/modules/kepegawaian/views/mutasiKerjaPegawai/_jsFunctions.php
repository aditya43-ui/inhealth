<script>

function setDataPegawai(params){
$("#form-pegawai > div").addClass("animation-loading");
$.ajax({
    type:'POST',
    url:"<?php echo $this->createUrl('/kepegawaian/pencatatanPekerjaan/getDataPegawai');?>",
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
		
		$("#KPPegmutasiR_jabatan_nama").val(data.jabatan_nama);
        
        $("#form-pegawai > legend > .judul").html('Data Pegawai '+data.nomorindukpegawai);
        $("#form-pegawai > legend > .tombol").attr('style','display:true;');
        $("#form-pegawai > .box").addClass("well").removeClass("box");
        
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

</script>