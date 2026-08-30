<?php
$this->breadcrumbs = array(
    'Informasi Keuangan Beban',
); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi Keuangan <b>Beban</b>
        </div>
    </div>
    <div class="panel-body">
        <iframe src="" id="iframe_dashboard" style="width: 100%; height: 100%;" onresize="javascript:resizeIframe(this);" onload="javascript:resizeIframe(this);"></iframe>
        <div class="form-actions">
            <?php
            $tips = array(
                '0' => 'cari',
                '1' => 'ulang',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php echo $this->renderPartial('_jsFunctions'); ?>
    </div>
</div>