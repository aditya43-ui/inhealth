<?php

/**
 * digunakan sebagai halaman utama 
 * 
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            .com
 * 
 */
$url = Yii::app()->createUrl('gudangFarmasi/laporan/FrameGrafikLaporanPenerimaanJenisItems&id=1');
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
            <i class="entypo-newspaper"></i> Laporan <b>Penerimaan Item - Berdasarkan Jenis</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('penerimaanJenisItems/_search', array('model' => $model, 'format' => $format)); ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penerimaan Item Berdasarkan Jenis</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('penerimaanJenisItems/_table', array('model' => $model, 'tgl_awal' => $model->tgl_awal, 'tgl_akhir' => $model->tgl_akhir, 'format' => $format)); ?>
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
        $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanPenerimaanJenisItems');
        $this->renderPartial('_footer', array('urlPrint' => $urlPrint, 'url' => $url));
        ?>
    </div>
</div>