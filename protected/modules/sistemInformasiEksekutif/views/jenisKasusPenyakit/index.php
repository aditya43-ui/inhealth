<?php
$this->breadcrumbs = array(
    'Informasi Pasien Jenis Kasus Penyakit'
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi Pasien <b>Jenis Kasus Penyakit</b>
        </div>
    </div>
    <div class="panel-body" style="padding: 5px;">
        <iframe src="" id="iframe_dashboard" width="100%" height="100%" onresize="javascript:resizeIframe(this);" onload="javascript:resizeIframe(this);"></iframe>
        <?php echo $this->renderPartial('_jsFunctions'); ?>
    </div>
</div>