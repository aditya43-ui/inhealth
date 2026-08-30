<?php
$this->breadcrumbs = array(
    'Laporan Mortalitas Pasien',
);
?>
<?php

$url = Yii::app()->createUrl($this->module->id . '/' . $this->id . '/frameGrafikLaporanMortalitas&id=1');
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $('#Grafik').attr('src','').css('height','0px');
    $.fn.yiiGridView.update('tableLaporan', {
            data: $(this).serialize()
    });
    return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Mortalitas Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="search-form panel-body">
                <?php $this->renderPartial('mortalitas/_search', array(
                    'model' => $model, 'format' => $format
                )); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Mortalitas Pasien</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('mortalitas/_table', array('model' => $model)); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-chart-bar"></i> Grafik
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_tab'); ?>
                <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
            </div>
        </div>

        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printLaporanMortalitas');
        $this->renderPartial('_footer', array('urlPrint' => $urlPrint, 'url' => $url, 'tips' => 'mortalitas')); ?>
        <?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>
    </div>
</div>