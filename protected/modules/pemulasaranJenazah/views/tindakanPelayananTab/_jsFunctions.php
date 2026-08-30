<?php
$gets = "";
if(isset($_GET)){
    foreach($_GET AS $name => $get){
        if($name != "r")
            $gets .= "&".$name."=".$get;
    }
}
$baseUrl = Yii::app()->createUrl("/");
?>
<script>
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
    function resetIframe(obj) {
        // obj.style.height = 128 + 'px';
    }
    function resizeIframe(obj) {
        obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
    }


    <?php $riwayatPasien = Yii::app()->createUrl('rawatJalan/daftarPasien/getRiwayatPasienLama&id=' . $modPasien->pasien_id); ?>

    function setRiwayatPasien(){
        var frameObj = document.getElementById("riwayatPasien");
        var jsframe = $("#riwayatPasien");

        jsframe.attr("src", "<?php echo $riwayatPasien; ?>");
        jsframe.parent().addClass("animation-loading");
        jsframe.on('load', function() {
            resizeIframeJs(jsframe);
            jsframe.parent().removeClass("animation-loading");
        });

        
        return false;
    }
    function resizeIframeJs(obj) {
        var h1 = obj.height();
        var h2 = 200;
        var h3 = h2 + h1;

        obj.attr("style", 'width: 100%; height:' + h3 + 'px;');
    }

    

    <?php
    Yii::app()->clientScript->registerScript('onLoadJs','
        setRiwayatPasien();
    ', CClientScript::POS_READY);
    ?>
</script>