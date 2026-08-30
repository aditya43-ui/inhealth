<?php


$default = 100; 

$gets = "";
if(isset($_GET)){
    foreach($_GET AS $name => $get){
        if($name != "r")
            $gets .= "&".$name."=".$get;
    }
}
?>
<?php $baseUrl = Yii::app()->createUrl("/");?>

<script type='text/javascript'>
function setTab1(obj){
    $(obj).parents("ul").find("li").each(function(){
        $(this).removeClass("active");
        $(this).attr("onclick","setTab1(this);");
    });
    $(obj).addClass("active");
    $(obj).removeAttr("onclick","setTab1(this);");
    var tab = $(obj).attr("tab");
    var frameObj = document.getElementById("framepemeliharaanaset");
    resetIframe(frameObj);
    $(frameObj).attr("src","<?php echo $baseUrl;?>?r="+tab+"<?php echo $gets;?>&frame=frame");
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
    obj.style.height = '700px';
}

function resizeIframeJs(obj) {  
    var h1 = obj.height();
    var h2 = 100;
    var h3 = h2+h1;
    
    obj.attr("style",'height:<?php echo $default; ?>px');
}





$("#cekRiwayatPasien").change(function(){
    $('#divRiwayatPasien').slideToggle(500);
});
</script>
<?php
Yii::app()->clientScript->registerScript('onLoadJs','
', CClientScript::POS_READY);
?>
