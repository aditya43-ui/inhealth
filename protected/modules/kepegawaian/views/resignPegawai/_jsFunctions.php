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
        $("#jeniskelamin").val(data.jeniskelamin);
        $("#statusperkawinan").val(data.statusperkawinan);
        $("#tglditerima").val(data.tglditerima);
        $("#alamat_pegawai").val(data.alamat_pegawai);
        
        // $("$jabatan_nama").val(data.jabatan_id);
        if(data.photopegawai != ""){
            var url = "<?php echo Params::urlPegawaiTumbsDirectory() . 'kecil_'; ?>" + data.photopegawai;
            $("#photo_pasien").attr('src', url);
        } else {
            var url = "<?php echo Params::urlPegawaiDirectory() . 'no_photo.jpeg'; ?>";
            $("#photo_pasien").attr('src',url);
        }  
		
		$("#KPResignT_jabatan_id").val(data.jabatan_id);
		$("#KPResignT_unitkerja_id").val(data.unitkerja_id);
        
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

function setUmur(tanggal_lahir)
{
	var resign = $("#tglditerima").val();
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetUmur'); ?>',
       data: {tanggal_lahir : tanggal_lahir, tglditerima : resign },//
       dataType: "json",
       success:function(data){
		   $("#KPResignT_lamakerja").val(data);
//		   console.log(data);
//           $("#<?php // echo CHtml::activeId($model,"umur");?>").val(data.umur);
//           setNamaDepan();
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

</script>