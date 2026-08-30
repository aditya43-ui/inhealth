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
<?php $riwayatPasien = Yii::app()->createUrl('rawatJalan/daftarPasien/getRiwayatPasienLama&id=' . $modPasien->pasien_id); ?>
<script type='text/javascript'>
function cekRM() {
    const id = $(".idrm").val();
    // alert('no rm', console.log(id)); 
    window.open(`http://192.168.0.23/smartplus/history/pasien/` + id, 'location=_new, width=900px');
}

const approveFrame = (obj, frameObj) => {
    $(obj).parents("ul").find("li").each(function() {
        $(this).removeClass("active");
        $(this).attr("onclick", "setTab(this);");
    });
    $(obj).addClass("active");
    $(obj).removeAttr("onclick", "setTab(this);");
    var tab = $(obj).attr("tab");

    resetIframe(frameObj);
    if (tab == 'smart') {
        cekRM();
        $(frameObj).removeAttr("src", "<?php echo $baseUrl; ?>?r=" + tab + "<?php echo $gets; ?>");
        $(frameObj).parent().removeClass("animation-loading");
    } else {
        $(frameObj).attr("src", "<?php echo $baseUrl; ?>?r=" + tab + "<?php echo $gets; ?>");
        $(frameObj).parent().addClass("animation-loading");
    }
    $(frameObj).load(function() {
        $(frameObj).parent().removeClass("animation-loading");
        resizeIframe(frameObj);
    });
}

function setTab(obj) {

    var frameObj = document.getElementById("frame");
    if (!cekSimpanTabulasi(frameObj, obj)) {
        return false;
    } else {
        approveFrame(obj, frameObj);
        return false;
    }
}

function setRiwayatPasien() {
    var frameObj = document.getElementById("riwayatPasien");
    $(frameObj).attr("src", "<?php echo $riwayatPasien;?>");
    $(frameObj).parent().addClass("animation-loading");
    $(frameObj).load(function() {
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

function resizeIframeJs(obj) {
    var h1 = obj.height();
    var h2 = 100;
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