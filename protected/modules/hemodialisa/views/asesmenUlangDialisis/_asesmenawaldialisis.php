<?php $baseUrl = Yii::app()->createUrl("/"); ?>
<?php
$asesmen = "";
if (!empty($_GET['pendaftaran_id'])) {
    $module = '/' . $this->module->id;
    $umur = explode(" ", $modPendaftaran->umur);
    if ((int) $umur[0] <= 18) {
        $asesmen = $module . '/asesmenAwalMedisAnakHD/index&pendaftaran_id=' . $_GET['pendaftaran_id'].'&from=asesmenulang';
    } else {
        $asesmen = $module . '/asesmenAwalMedisDewasaHD/index&pendaftaran_id=' . $_GET['pendaftaran_id'].'&from=asesmenulang';
    }
}

$url = "";
if (!empty($_GET['pendaftaran_id'])) {
    $url = $baseUrl."?r=".$asesmen;
} 
?>
<div>
    <iframe class="biru" src="<?= $url?>" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; overflow-x: scroll; height: 4059px;" ></iframe>
</div>
<script type='text/javascript'>
    function setAsesmenAwal() {
        var frameObj = document.getElementById("frame");
//        var tab = "<?= $asesmen ?>";
//        $(frameObj).attr("src", "<?php echo $baseUrl; ?>?r=" + tab);
//        $(frameObj).parent().addClass("animation-loading");
        $(frameObj).load(function () {
//            $(frameObj).parent().removeClass("animation-loading");
            resizeIframe(frameObj);
        });

        return false;
    }

    function setAsesmen(tab) {
        var frameObj = document.getElementById("frame");
        $(frameObj).attr("src", "<?php echo $baseUrl; ?>?r=" + tab);
        $(frameObj).parent().addClass("animation-loading");
        $(frameObj).load(function () {
            $(frameObj).parent().removeClass("animation-loading");
            resizeIframe(frameObj);
        });

        return false;
    }

    function resetIframe(obj) {
        obj.style.height = 128 + 'px';
    }
    function resizeIframe(obj) {
        obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
    }

    $(document).ready(function () {
//        setAsesmenAwal();
    });

</script>