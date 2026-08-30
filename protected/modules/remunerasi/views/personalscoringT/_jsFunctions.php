<script type="text/javascript">
/**
 * setPegawai
 * @param {type} pegawai_id
 * @returns {undefined}
 */
function setPegawai(pegawai_id){
    $("#form-datapegawai > div").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataPegawai'); ?>',
        data: {pegawai_id:pegawai_id},
        dataType: "json",
        success:function(data){
            $("#pegawai_id").val(data.pegawai_id);
            $("#<?php echo CHtml::activeId($modPegawai,'nama_pegawai'); ?>").val(data.nama_pegawai);
            $("#tempatlahir_pegawai").val(data.tempatlahir_pegawai);
            $("#tgl_lahirpegawai").val(data.tgl_lahirpegawai);
            $("#jeniskelamin").val(data.jeniskelamin);
            $("#NIP").val(data.nomorindukpegawai);
            $("#jabatan").val(data.jabatan);
            $("#pangkat").val(data.pangkat);
            $("#pendidikan").val(data.pendidikan);
            $("#gajipokok").val(data.gajipokok);
            $("#kategoripegawai").val(data.kategoripegawai);
            $("#kelompokpegawai").val(data.kelompokpegawai);
            $("#statusperkawinan").val(data.statusperkawinan);
            
            if(data.photopegawai === null || data.photopegawai === ""){ //set photo
                $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
            }else{
                $('#photo-preview').attr('src','<?php echo Params::urlPegawaiTumbsDirectory()."kecil_"?>'+data.photopegawai);
            }
            $("#form-datapegawai > legend > .tombol").attr('style','display:true;');
            $("#form-datapegawai > .box").addClass("well").removeClass("box");
            
            $("#form-datapegawai > div").removeClass("animation-loading");
            $("#<?php echo CHtml::activeId($modPegawai,'nama_pegawai'); ?>").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data Pegawai tidak ditemukan!"); 
            console.log(errorThrown);
            setPegawaiReset();
            $("#form-datapegawai > div").removeClass("animation-loading");
        }
    });
}      
/**
 * untuk mereset form pegawai
 * @returns {undefined} */
function setPegawaiReset(){
    $("#<?php echo CHtml::activeId($modPegawai,'pegawai_id'); ?>").val("");
    $("#<?php echo CHtml::activeId($modPegawai,'nama_pegawai'); ?>").val("");
    $("#<?php echo CHtml::activeId($modPegawai,'tempatlahir_pegawai'); ?>").val("");
    $("#<?php echo CHtml::activeId($modPegawai,'tgl_lahirpegawai'); ?>").val("");
    $("#<?php echo CHtml::activeId($modPegawai,'jeniskelamin'); ?>").val("");
    $("#jabatan").val("");
    $("#pangkat").val("");
    $("#pendidikan").val("");
    $("#gajipokok").val("");
    $("#kategoripegawai").val("");
    $("#kelompokpegawai").val("");
    $('#photo-preview').attr('src','<?php echo Params::urlPegawaiDirectory()."no_photo.jpeg"?>');
    $("#form-datapegawai > legend > .judul").html('Data Pegawai');
    $("#form-datapegawai > legend > .tombol").attr('style','display:none;');
    $("#form-datapegawai > .well").addClass("box").removeClass("well");
}
$(document).ready(function(){
    
    var personalscoring_id = '<?php echo isset($model->personalscoring_id) ? $model->personalscoring_id : null; ?>';
    if(personalscoring_id != ""){
        $("#form-datapegawai :input").attr("readonly",true);
        $("#form-datapegawai .dtPicker3").attr("readonly",true);
        $("#form-datapegawai .add-on").remove();
        
        $("input, select, textarea").attr("disabled",true);        
    }
});
</script>