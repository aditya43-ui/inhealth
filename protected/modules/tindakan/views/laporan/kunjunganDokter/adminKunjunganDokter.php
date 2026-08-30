<?php
$url = Yii::app()->createUrl('pendaftaranPenjadwalan/laporan/frameGrafikKunjunganDokter&id=1');
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
<?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); ?><legend class="rim2">Laporan Kunjungan</legend>
<div class="search-form">
<?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan.kunjunganDokter/_searchKunjunganDokter',array(
    'model'=>$model,
)); ?>
</div><!--search-form--> 
<fieldset> 
    <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan.kunjunganDokter/_tableKunjunganDokter', array('model'=>$model)); ?>
    <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan._tab'); ?>
    <iframe src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
    </iframe>        
</fieldset>
<?php 
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanKunjunganDokter');
$this->renderPartial('pendaftaranPenjadwalan.views.laporan._footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>