<?php
$baseUrl = Yii::app()->createUrl("/");
$gets = '';
?>
<script type='text/javascript'>
    
    function setTab(obj) {
        $(obj).parents("ul").find("li").each(function () {
                $(this).removeClass("active");
                $(this).attr("onclick", "setTab(this);");
            });
            $(obj).addClass("active");
            $(obj).removeAttr("onclick", "setTab(this);");
            var tab = $(obj).attr("tab");
            var frameObj = document.getElementById("frame");
            resetIframe(frameObj);
            $(frameObj).attr("src", "<?php echo $baseUrl; ?>?r=" + tab);
            $(frameObj).parent().addClass("animation-loading");
            $(frameObj).load(function () {
                $(frameObj).parent().removeClass("animation-loading");
                resizeIframe(frameObj);
            });
        return false;

    }

    function setTabReset() {
        $(".nav-tabs > .active").attr("onclick", "setTab(this);");
        $(".nav-tabs > .active").removeClass("active");
        
        $("#frame").attr("src", "");
    }

    function resetIframe(obj) {
        obj.style.height = 128 + 'px';
    }

    function resizeIframe(obj) {
        obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
    }

</script>

<?php
Yii::app()->clientScript->registerScript('onLoadJs','
	setTab($("#tab-default"));
        if(document.getElementById("frame") != null){
            resizeIframe(document.getElementById("frame"));
        }
', CClientScript::POS_READY);
 
?>