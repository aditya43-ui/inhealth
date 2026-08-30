<?php
	$url = $this->createUrl('frameGrafik&id=1');
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
<div class="white-container">
    <legend class="rim2">Laporan Pelayanan <b>Non Paket</b></legend>
    <div class="box search-form">
        <?php 
            $this->renderPartial($this->path_view.'_search',array(
				'model'=>$model,
				'format'=>$format
            )); 
        ?>
    </div>
    <div class="block-tabel">
        <h6>Tabel Pelayanan <b>Non Paket</b></h6>
        <?php $this->renderPartial($this->path_view.'_table', array('model'=>$model)); ?>
    </div>
    <div class="block-tabel">
        <?php $this->renderPartial($this->path_view.'_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>
    </div>
    <?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $this->renderPartial($this->path_view.'_footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>
</div>