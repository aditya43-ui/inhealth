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
function setTabPemeliharaan(obj){
    $(obj).parents("ul").find("li").each(function(){
        $(this).removeClass("active");
        $(this).attr("onclick","setTab(this);");
    });
    $(obj).addClass("active");
    $(obj).removeAttr("onclick","setTab(this);");
    var tab = $(obj).attr("tab");
    var frameObj = document.getElementById("frame_pemeliharaan");
    resetIframe(frameObj);
    $(frameObj).attr("src","<?php echo $baseUrl;?>?r="+tab+"<?php echo $gets;?>");
    $(frameObj).parent().addClass("animation-loading");
    $(frameObj).load(function(){
        $(frameObj).parent().removeClass("animation-loading");
        resizeIframe(frameObj);
    });
    return false;
}

</script>
