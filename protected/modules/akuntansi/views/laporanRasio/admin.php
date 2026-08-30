
<?php

    $this->breadcrumbs=array(
    'Laporan Rasio',
    );

$url = Yii::app()->createUrl('akuntansi/laporanRasio/frameGrafikLaporanrasio&id=1');
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
    <legend class="rim2">Laporan <b>Rasio</b></legend>
    <div class="search-form">
        <?php $this->renderPartial($this->path_view.'_search',array('model'=>$model,'models'=>$models)); ?>
    </div>
    <div class="block-tabel"> 
        <h6>Tabel <b>Rasio Keuangan</b></h6>
        <?php $this->renderPartial($this->path_view.'_table', array('model'=>$model,'models'=>$models)); ?>
    </div>
    <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanRasio');
        $this->renderPartial('akuntansi.views.laporanAkuntansi._footerNoGraph', array('urlPrint'=>$urlPrint, 'url'=>$url)); 
    ?>
	<?php $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model,'models'=>$models)); ?>
</div>