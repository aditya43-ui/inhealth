<?php

/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 * digunakan untuk menampilkan tab menu di halaman Riwayat Pemeriksaan di menu Informasi Daftar Pasien MC
 */
?>
<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked' => false, // whether this is a stacked menu
    'items' => array(
        array('label' => 'Pemeriksaan Medis', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => ('/mcu/InformasiDaftarPasienMC/riwayatMCU'))),
        array('label' => 'Laboratorium PK', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => ('/mcu/InformasiDaftarPasienMC/riwayatLab'))),
        array('label' => 'Radiologi', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => ('/mcu/InformasiDaftarPasienMC/riwayatRad'))),
        array('label' => 'Treadmill', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => ('/mcu/InformasiDaftarPasienMC/riwayatTreadmill'))),

    ),
));
?>
<div>
    <iframe class="biru" id="frame" src="" frameborder="0" style="overflow-y:scroll" width="100%" height="100%" onresize="javascript:resizeIframe(this);" onload="javascript:resizeIframe(this);"></iframe>
</div>
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
        $(frameObj).attr("src", <?php $baseUrl ?> "?r=" + tab + "<?php echo $gets; ?>");
        $(frameObj).parent().addClass("animation-loading");
        $(frameObj).load(function() {
            $(frameObj).parent().removeClass("animation-loading");
            resizeIframe(frameObj);
        });
        return false;
    }

    function resetIframe(obj) {
        obj.style.height = 128 + 'px';
    }

    function resizeIframe(obj) {
        obj.style.height = (obj.contentWindow.document.body.scrollHeight + 25) + 'px';
    }
</script>
<?php
Yii::app()->clientScript->registerScript('onLoadJs', '
	setTab($("#tab-default"));
	resizeIframe(document.getElementById("frame"));
', CClientScript::POS_READY);

?>