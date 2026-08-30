<?php

$url = Yii::app()->createUrl($this->module->id.'/'.$this->id.'/frameGrafikLaporanPenjualanLembarResep&id=1');
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
?><legend class="rim2">Laporan Penjualan Lembar Resep</legend>
<?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="search-form">
<?php $this->renderPartial('lembarResep/_search',array(
    'model'=>$model,
)); ?>
</div><!--search-form--> 
<fieldset> 
    <legend class="rim">Tabel Laporan Penjualan Lembar Resep</legend>
    <?php $this->renderPartial('lembarResep/_table', array('model'=>$model)); ?>
    <?php $this->renderPartial('_tab'); ?>
    <iframe src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
    </iframe>        
</fieldset>
<?php 

$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/printLaporanPenjualanLembarResep');
$this->renderPartial('lembarResep/_footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>