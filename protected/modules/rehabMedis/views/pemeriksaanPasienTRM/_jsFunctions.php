<?php
$gets = "";
if (isset($_GET)) {
    foreach ($_GET as $name => $get) {
        if ($name != "r")
            $gets .= "&" . $name . "=" . $get;
    }
    $gets .= "&frame=1";
}
?>
<?php $baseUrl = Yii::app()->createUrl("/"); ?>
<?php $riwayatPasien = Yii::app()->createUrl('rawatJalan/daftarPasien/getRiwayatPasien&id=' . $modPasien->pasien_id); ?>
<script type='text/javascript'>
    const approveFrame = (obj, frameObj) => {
        $(obj).parents("ul").find("li").each(function() {
            $(this).removeClass("active");
            $(this).attr("onclick", "setTab(this);");
        });
        $(obj).addClass("active");
        $(obj).removeAttr("onclick", "setTab(this);");
        var tab = $(obj).attr("tab");

        resetIframe(frameObj);                
        $(frameObj).attr("src", "<?php echo $baseUrl; ?>?r=" + tab + "<?php echo $gets; ?>");
        $(frameObj).parent().addClass("animation-loading");
        $(frameObj).load(function() {
            $(frameObj).parent().removeClass("animation-loading");
            resizeIframe(frameObj);
        });
    }
    
    function setTab(obj) {
        
        var frameObj = document.getElementById("frame");
        if (!cekSimpanTabulasi(frameObj, obj)){
            return false;
        }else{        
            approveFrame(obj, frameObj);
            return false;
        }
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
        var h2 = 200;
        var h3 = h2 + h1;

        obj.attr("style", 'width: 100%; height:' + h3 + 'px;');
    }

    $("#cekRiwayatPasien").change(function() {
        $('#divRiwayatPasien').slideToggle(500);
    });
</script>
<?php
Yii::app()->clientScript->registerScript('onLoadJs', '
    setRiwayatPasien();
', CClientScript::POS_READY);
?>