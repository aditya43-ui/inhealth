<?php
$gets = "";
if(isset($_GET)){
    foreach($_GET AS $name => $get){
        if($name != "r")
            $gets .= "&".$name."=".$get;
    }
}
?>
<?php $baseUrl = Yii::app()->createUrl("/");?>
<?php $riwayatPasien = Yii::app()->createUrl('gizi/daftarPasien/getRiwayatPasien&id='.$modPasien->pasien_id); ?>
<script type='text/javascript'>
function setTab(obj){
    $(obj).parents("ul").find("li").each(function(){
        $(this).removeClass("active");
        $(this).attr("onclick","setTab(this);");
    });
    $(obj).addClass("active");
    $(obj).removeAttr("onclick","setTab(this);");
    var tab = $(obj).attr("tab");
    var frameObj = document.getElementById("frame");
    resetIframe(frameObj);
    $(frameObj).attr("src","<?php echo $baseUrl;?>?r="+tab+"<?php echo $gets;?>");
    $(frameObj).parent().addClass("animation-loading");
    $(frameObj).load(function(){
        $(frameObj).parent().removeClass("animation-loading");
        resizeIframe(frameObj);
    });
    return false;
}
function setRiwayatPasien(){
    var frameObj = document.getElementById("riwayatPasien");
    $(frameObj).attr("src","<?php echo $riwayatPasien;?>");
    $(frameObj).parent().addClass("animation-loading");
    $(frameObj).load(function(){
        resizeIframe(frameObj);
        $(frameObj).parent().removeClass("animation-loading");
        $("#divRiwayatPasien").slideToggle(500);
    });
    return false;
}
function resetIframe(obj) {
    obj.style.height = 128 + 'px';
}
function resizeIframe(obj) {
    obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
}
$("#cekRiwayatPasien").change(function(){
    $('#divRiwayatPasien').slideToggle(500);
});
</script>
<?php
Yii::app()->clientScript->registerScript('onLoadJs','
    setRiwayatPasien();
', CClientScript::POS_READY);
?>
