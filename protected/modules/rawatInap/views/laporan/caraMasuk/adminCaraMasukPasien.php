<?php

$url = Yii::app()->createUrl('rawatDarurat/laporan/frameGrafikLaporanCaraMasukPasien&id=1');
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

<div class="search-form">
<?php $this->renderPartial('caraMasuk/_searchCaraMasuk',array(
    'model'=>$model, 'filter'=>$filter
)); ?>
</div><!--search-form--> 
<fieldset> 
    <legend class="rim">Tabel Cara Masuk</legend>
    <?php $this->renderPartial('caraMasuk/_tableCaraMasuk', array('model'=>$model)); ?>
    <?php $this->renderPartial('_tab'); ?>
    <iframe src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
    </iframe>        
</fieldset>
<?php 

$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanCaraMasukPasien');
$this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>