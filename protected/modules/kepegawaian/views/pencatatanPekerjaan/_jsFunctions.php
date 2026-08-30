<?php 
    $baseUrl = Yii::app()->createUrl("/");
    $gets = '';
?>
<script type='text/javascript'>

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
        if(data.photopegawai != ""){
            var url = "<?php echo Params::urlPegawaiTumbsDirectory() . 'kecil_'; ?>" + data.photopegawai;
            $("#photo_pasien").attr('src', url);
        } else {
            var url = "<?php echo Params::urlPegawaiDirectory() . 'no_photo.jpeg'; ?>";
            $("#photo_pasien").attr('src',url);
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
    var url = "<?php echo Params::urlPegawaiDirectory() . 'no_photo.jpeg'; ?>";
    $("#photo_pasien").attr('src',url);
    $("#form-pegawai > legend > .judul").html('Data Pegawai');
    $("#form-pegawai > legend > .tombol").attr('style','display:none;');
    $("#form-pegawai > .well").addClass("box").removeClass("well");
    $("#form-pegawai > div").removeClass("animation-loading");
    $("#nomorindukpegawai").focus();

    setTabReset()
}

function setTab(obj){
    var pegawai_id = $("#pegawai_id").val();
    if(pegawai_id !== ""){
        $(obj).parents("ul").find("li").each(function(){
            $(this).removeClass("active");
            $(this).attr("onclick","setTab(this);");
        });
        $(obj).addClass("active");
        $(obj).removeAttr("onclick","setTab(this);");
        var tab = $(obj).attr("tab");
        var frameObj = document.getElementById("frame");
        resetIframe(frameObj);
        $(frameObj).attr("src","<?php echo $baseUrl;?>?r="+tab+"&pegawai_id="+pegawai_id);
        $(frameObj).parent().addClass("animation-loading");
        $(frameObj).load(function(){
            $(frameObj).parent().removeClass("animation-loading");
            resizeIframe(frameObj);
        });
    }else{
        myAlert("Silakan pilih data pegawai!");
    }
    return false;

}

function setTabReset(){
    $(".nav-tabs > .active").removeClass("active");
    $("#frame").attr("src","");
}

function resetIframe(obj) {
    obj.style.height = 128 + 'px';
}

function resizeIframe(obj) {
    obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
}

</script>
<?php
// Yii::app()->clientScript->registerScript('onLoadJs','
//     setTab($("#tab-default"));
//     resizeIframe(document.getElementById("frame"));    
// ', CClientScript::POS_READY);

Yii::app()->clientScript->registerScript('onLoadJs','
    resizeIframe(document.getElementById("frame"));    
', CClientScript::POS_READY);

?>