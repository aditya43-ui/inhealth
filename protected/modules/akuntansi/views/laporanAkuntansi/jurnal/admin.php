<?php
$this->breadcrumbs = array(
    'Laporan Jurnal',
);
$url = Yii::app()->createUrl('akuntansi/laporanAkuntansi/frameGrafikLaporanJurnal&id=1');
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Jurnal</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('akuntansi.views.laporanAkuntansi.jurnal/_search', array(
            'model' => $model
        )); ?>

        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Jurnal</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('akuntansi.views.laporanAkuntansi.jurnal/_tableBaru', array('model' => $model)); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <?php $this->renderPartial('akuntansi.views.laporanAkuntansi._tab'); ?>
            <div class="panel-body">
                <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
            </div>
        </div>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanJurnal');
        $this->renderPartial('akuntansi.views.laporanAkuntansi._footer', array('urlPrint' => $urlPrint, 'url' => $url));
        ?>
    </div>
</div>