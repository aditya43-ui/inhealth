<?php

/**
 * digunakan sebagai halaman utama 
 * 
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            .com
 * 
 */
$this->breadcrumbs = array(
    'Laporan Mutasi Obat Alkes',
);
$url = Yii::app()->createUrl('gudangFarmasi/laporan/FrameGrafikLaporanMutasiObatAlkes&id=1');
Yii::app()->clientScript->registerScript('search', "
$('#search-laporan').submit(function(){
	$.fn.yiiGridView.update('laporan-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Mutasi Obat Alkes</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view_gudang . 'mutasiObatAlkes/_search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Mutasi Obat Alkes</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel">
                    <?php $this->renderPartial($this->path_view_gudang . 'mutasiObatAlkes/_table', array('model' => $model, 'format' => $format)); ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-chart-pie"></i> Grafik
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view_gudang . '_tab'); ?>
                <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
            </div>
        </div>

        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanMutasiObatAlkes');
        $this->renderPartial($this->path_view_gudang . '_footer', array('urlPrint' => $urlPrint, 'url' => $url));
        ?>
    </div>
</div>