<?php
/**
 * digunakan sebagai halaman utama 
 * 
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            .com
 * 
 */
$url = Yii::app()->createUrl('gudangFarmasi/laporan/FrameGrafikLaporanPenerimaanItems&id=1');
Yii::app()->clientScript->registerScript('search', "
$('#search-laporan').submit(function(){
	$.fn.yiiGridView.update('laporan-grid', {
		data: $(this).serialize()
	});
	return false;
});
");php
?>
<legend class="rim2">Laporan Penerimaan Items</legend>
<?php $this->renderPartial('penerimaanItems/_search',array('model'=>$model)); ?>
<fieldset>
    <?php $this->renderPartial('penerimaanItems/_table',array('model'=>$model)); ?>
    <?php $this->renderPartial('_tab'); ?>
    <iframe src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
</fieldset>
<?php        
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanPenerimaanItems');
$this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));
?>
