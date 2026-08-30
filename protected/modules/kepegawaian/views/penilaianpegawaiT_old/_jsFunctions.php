<script type="text/javascript">
function setDataPegawai(params){
$("#form-pegawai > div").addClass("animation-loading");
$.ajax({
    type:'POST',
    url:"<?php echo $this->createUrl('getDataPegawai');?>",
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
        $("#jabatan_id").val(data.jabatan_id);
        $("#jabatan_nama").val(data.jabatan_nama);
        $("#pangkat_id").val(data.pangkat_id);
        $("#pangkat_nama").val(data.pangkat_nama);
        $("#kategoripegawai").val(data.kategoripegawai);
        $("#kategoripegawaiasal").val(data.kategoripegawaiasal);
        $("#kelompokpegawai_id").val(data.kelompokpegawai_id);
        $("#kelompokpegawai_nama").val(data.kelompokpegawai_nama);
        $("#pendidikan_id").val(data.pendidikan_id);
        $("#pendidikan_nama").val(data.pendidikan_nama);
        if(data.photopegawai != ""){
            var url = "<?php echo Params::urlPegawaiTumbsDirectory() . 'kecil_'; ?>" + data.photopegawai;
            $("#photo_pegawai").attr('src', url);
        } else {
            var url = "<?php echo Params::urlPegawaiDirectory() . 'no_photo.jpeg'; ?>";
            $("#photo_pegawai").attr('src',url);
        }  
        
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
    $("#jabatan_id").val("");
    $("#jabatan_nama").val("");
    $("#pangkat_id").val("");
    $("#pangkat_nama").val("");
    $("#kategoripegawai").val("");
    $("#kategoripegawaiasal").val("");
    $("#kelompokpegawai_id").val("");
    $("#kelompokpegawai_nama").val("");
    $("#pendidikan_id").val("");
    $("#pendidikan_nama").val("");
    var url = "<?php echo Params::urlPegawaiDirectory() . 'no_photo.jpeg'; ?>";
    $("#photo_pegawai").attr('src',url);
    $("#form-pegawai > legend > .judul").html('Data Pegawai');
    $("#form-pegawai > legend > .tombol").attr('style','display:none;');
    $("#form-pegawai > .well").addClass("box").removeClass("well");
    $("#form-pegawai > div").removeClass("animation-loading");
    $("#nomorindukpegawai").focus();
}

function getDataPemimpin(params)
{
    $.post("<?php echo $this->createUrl('getDataPegawai');?>", {idPegawai:params },
        function(data){
            $("#<?php echo CHtml::activeId($model,'pimpinannama') ?>").val(data.nama_pegawai);
            $("#<?php echo CHtml::activeId($model,'pimpinannip') ?>").val(data.nomorindukpegawai);
            $("#<?php echo CHtml::activeId($model,'pimpinanjabatan') ?>").val(data.jabatan_nama);
            $("#<?php echo CHtml::activeId($model,'pimpinanunitorganisasi') ?>").val(data.nama_pegawai);             
        }, "json");
}

function getDataPenilai(params)
{
    $.post("<?php echo $this->createUrl('getDataPegawai');?>", {idPegawai:params },
        function(data){
            $("#<?php echo CHtml::activeId($model,'penilainama') ?>").val(data.nama_pegawai);
            $("#<?php echo CHtml::activeId($model,'penilainip') ?>").val(data.nomorindukpegawai);
            $("#<?php echo CHtml::activeId($model,'penilaijabatan') ?>").val(data.jabatan_nama);
            $("#<?php echo CHtml::activeId($model,'penilaiunitorganisasi') ?>").val(data.nama_pegawai);             
        }, "json");
}
/**
* untuk print penilaian pegawai
 */
function print(caraPrint)
{
    var penilaianpegawai_id = '<?php echo isset($model->penilaianpegawai_id) ? $model->penilaianpegawai_id : null ?>';
    window.open('<?php echo $this->createUrl('PrintDetailPenilaian'); ?>&penilaianpegawai_id='+penilaianpegawai_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
	var pegawai_id = '<?php echo isset($_GET['id']) ? $_GET['id'] : null; ?>';
	if(pegawai_id != ''){
			$('#form-pegawai .add-on').remove();
	}
});
</script>