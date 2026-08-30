<?php
$url = Yii::app()->createUrl('laboratoriumPA/laporan/frameGrafikLaporanCaraMasukPasien&id=1');
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#Grafik').attr('src','').css('height','0px');
	$('#tableLaporan').addClass('animation-loading');
	$.fn.yiiGridView.update('tableLaporan', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Laporan <strong>Cara Masuk</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
						<div class="box search-form">
							<?php $this->renderPartial('caraMasuk/_search',array(
								'model'=>$model
							)); ?>
						</div><!-- search-form --> 
                    </div>
                </div>								
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Cara Masuk</strong></div>
                    </div>
                    <div class="panel-body" style="overflow-x: scroll">
						<div class="block-tabel"> 
							<?php $this->renderPartial('caraMasuk/_table', array('model'=>$model)); ?>
						</div>
                    </div>
                </div>								
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Grafik</div>
                    </div>
                    <div class="panel-body">
						<div class="block-tabel">
							<?php $this->renderPartial('_tab'); ?>
							<iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
							</iframe>        
						</div>
                    </div>
                </div>							
				<?php 
				$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
				$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
				$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanCaraMasukPasien');
				$this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>
            </div>
        </div>
    </div>
</div>
