<?php
$default = 100; 
$vars = $_GET;
unset($vars['r']);
$gets = '&'.http_build_query($vars);
?>
<?php $baseUrl = Yii::app()->createUrl("/");?>
<script>
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
            $(frameObj).attr("src", "<?php echo $baseUrl; ?>?r=" + tab + "<?php echo $gets; ?>");
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