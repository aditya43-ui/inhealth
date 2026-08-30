<?php
$url = Yii::app()->createUrl('gudangFarmasi/laporan/FrameGrafikLapTerimaOABySupplier&id=1');
Yii::app()->clientScript->registerScript('search', "
$('#search-laporan').submit(function(){
	$.fn.yiiGridView.update('laporan-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-multiselect/js/bootstrap-multiselect.js', CClientScript::POS_END);
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('penerimaanObatAlkes/_searchSupplier', array('model' => $model, 'format' => $format)); ?>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Penerimaan Obat Alkes</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->renderPartial('penerimaanObatAlkes/_tableSupplier', array('model' => $model, 'format' => $format)); ?>
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
        <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);">
        </iframe>
    </div>
</div>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanPenerimaanObatAlkesSupplier');
$this->renderPartial('_footer', array('urlPrint' => $urlPrint, 'url' => $url));
?>