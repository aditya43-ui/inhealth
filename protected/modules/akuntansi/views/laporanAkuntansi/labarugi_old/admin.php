<?php
$url = Yii::app()->createUrl('akuntansi/laporanAkuntansi/frameGrafikLaporanRugiLaba&id=1');
Yii::app()->clientScript->registerScript('search', "
$('#searchLaporan').submit(function(){
    $('#Grafik').attr('src','').css('height','0px');
	$('#tableLaporan').addClass('srbacLoading');
	$.fn.yiiGridView.update('tableLaporan', {
		data: $(this).serialize()
	});
    return false;
});
");
?>
<div class='white-container'>
    <legend class="rim2">Laporan <b>Laba Rugi</b></legend>
    <fieldset class="box search-form">
        <?php $this->renderPartial('akuntansi.views.laporanAkuntansi.labarugi/_search',array('model'=>$model)); 
        ?>
    </fieldset>
    <div class='block-tabel'> 
        <h6>Tabel <b>Laba Rugi</b></h6>
        <?php $this->renderPartial('akuntansi.views.laporanAkuntansi.labarugi/_table', array('model'=>$model)); ?>
        <iframe src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
    <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanLabaRugi');
        $this->renderPartial('akuntansi.views.laporanAkuntansi._footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); 
    ?>
</div>