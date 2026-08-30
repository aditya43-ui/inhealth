<?php $baseUrl = Yii::app()->createUrl("/");
?>
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
    $(frameObj).attr("src","<?php echo $baseUrl;?>?r="+tab+"&filterruangan=<?php echo (in_array(Yii::app()->user->getState('instalasi_id'), array(Params::INSTALASI_ID_IBS))?1:''); ?>");
    $(frameObj).parent().addClass("animation-loading");
    $(frameObj).load(function(){
         $(frameObj).parent().removeClass("animation-loading");
         resizeIframe(frameObj);
    });
    return false;
}
function resetIframe(obj) {
    obj.style.height = 128 + 'px';
}
function resizeIframe(obj) {
    obj.style.height = (obj.contentWindow.document.body.scrollHeight+25) + 'px';
}
</script>
<?php
Yii::app()->clientScript->registerScript('onLoadJs','
    setTab($("#tab-default"));
    resizeIframe(document.getElementById("frame"));
', CClientScript::POS_READY);
 
?>