<?php
    
	$url = Yii::app()->createUrl('akuntansi/laporanAkuntansi/frameGrafikLaporanJurnal&id=1');
	Yii::app()->clientScript->registerScript('search', "
		$('.search-button').click(function(){
			$('.search-form').toggle();
			return false;
		});
		$('.search-form').submit(function(){
			$('#Grafik').attr('src','').css('height','0px');
			$.fn.yiiGridView.update('tableLaporan', {
					data: $(this).serialize()
			});
			return false;
		});
	");
?>
<div class='white-container'>
    <legend class="rim2">Laporan Posisi <b>Keuangan / Neraca</b></legend>
    <fieldset class="box search-form">
        <?php $this->renderPartial('akuntansi.views.laporanAkuntansi.neraca/_search',array('model'=>$model,'modelLaporan'=>$modelLaporan)); 
        ?>
    </fieldset><!--search-form--> 
    <div class='block-tabel'> 
        <h6>Tabel <b>Neraca</b></h6>
        <?php $this->renderPartial('akuntansi.views.laporanAkuntansi.neraca/_table2', array('model'=>$model,'modelLaporan'=>$modelLaporan)); ?>
        <?php //$this->renderPartial('_tab'); ?>
        <iframe src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);"></iframe>      
    </div>
    <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanNeraca');
        $this->renderPartial('akuntansi.views.laporanAkuntansi._footerNoGraph', array('urlPrint'=>$urlPrint, 'url'=>$url)); 
    ?>
</div>