<div class="white-container">
    <legend class="rim2">Laporan <b>Pembayaran Jasa Dokter</b></legend>
<?php 
$url = Yii::app()->createUrl('billingKasir/laporan/FrameGrafikLaporanJasaDokter&id=1');
Yii::app()->clientScript->registerScript('search', "
$('#searchLaporan').submit(function(){
	$.fn.yiiGridView.update('laporan-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php $this->renderPartial('jasaDokter/_search',array('model'=>$model)); ?>
<fieldset>
    <?php $this->renderPartial('jasaDokter/_table',array('model'=>$model)); ?>
    <?php // $this->renderPartial('_tab'); ?>
    <iframe src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
</fieldset>
<?php        
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanJasaDokter');
$this->renderPartial('_footer2', array('urlPrint'=>$urlPrint, 'url'=>$url));
?>
</div>