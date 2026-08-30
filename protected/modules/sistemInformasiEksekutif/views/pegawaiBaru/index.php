<?php
$this->breadcrumbs = array(
    'Informasi Pegawai Pegawai Baru'
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi Pegawai <b>Pegawai Baru</b>
        </div>
    </div>
    <div class="panel-body">
        <iframe src="" id="iframe_dashboard" width="100%" height="100%" onresize="javascript:resizeIframe(this);" onload="javascript:resizeIframe(this);"></iframe>
        <?php echo $this->renderPartial($this->path_view.'_jsFunctions'); ?>
    </div>
</div>