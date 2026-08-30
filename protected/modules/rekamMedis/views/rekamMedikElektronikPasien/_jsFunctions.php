<?php
$gets = "";
if (isset($_GET)) {
    foreach ($_GET as $name => $get) {
        if ($name != "r")
            $gets .= "&" . $name . "=" . $get;
    }
}
?>
<?php $baseUrl = Yii::app()->createUrl("/"); ?>
<?php $riwayatPasien = Yii::app()->createUrl('rawatJalan/daftarPasien/getRiwayatPasien&id=' . $modPasien->pasien_id); ?>
<script type='text/javascript'>
    function setTab(obj) {
        $(obj).parents("ul").find("li").each(function() {
            $(this).removeClass("active");
            $(this).attr("onclick", "setTab(this);");
        });
        $(obj).addClass("active");
        $(obj).removeAttr("onclick", "setTab(this);");
        var tab = $(obj).attr("tab");
        var frameObj = document.getElementById("frame");
        resetIframe(frameObj);
        $(frameObj).attr("src", "<?php echo $baseUrl; ?>?r=" + tab + "<?php echo $gets; ?>&frame=1");
        $(frameObj).parent().addClass("animation-loading");
        $(frameObj).load(function() {
            $(frameObj).parent().removeClass("animation-loading");
            resizeIframe(frameObj);
        });
        return false;
    }

    function setRiwayatPasien() {
        var frameObj = document.getElementById("riwayatPasien");
        var jsframe = $("#riwayatPasien");

        jsframe.attr("src", "<?php echo $riwayatPasien; ?>");
        jsframe.parent().addClass("animation-loading");
        jsframe.on('load', function() {
            resizeIframeJs(jsframe);
            jsframe.parent().removeClass("animation-loading");
        });

        //jsframe.parent().removeClass("animation-loading");        
        //$("#divRiwayatPasien").slideToggle(500);
        //});

        /*$(frameObj).attr("src","<?php //echo $riwayatPasien;
                                    ?>");
        $(frameObj).parent().addClass("animation-loading");
        $(frameObj).load(function(){
            resizeIframe(frameObj);
            $(frameObj).parent().removeClass("animation-loading");        
            $("#divRiwayatPasien").slideToggle(500);
        });*/
        return false;
    }

    function resetIframe(obj) {
        obj.style.height = 128 + 'px';
    }

    function resizeIframe(obj) {
        obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
    }

    function resizeIframeJs(obj) {
        var h1 = obj.height();
        var h2 = 100;
        var h3 = h2 + h1;

        obj.attr("style", 'width: 100%; height:' + h3 + 'px;');
    }
    $(document).ready(function(){
        var type = '<?php echo $_GET['type']?>';

        if(type == 'Dokter'){
            $('#textpanel').html('Diisi Oleh Dokter')
        }else{
            $('#textpanel').html('Diisi Oleh Perawat/ Bidan')
        }
    })
</script>
<?php
Yii::app()->clientScript->registerScript('onLoadJs', '
    setRiwayatPasien();
', CClientScript::POS_READY);
?>