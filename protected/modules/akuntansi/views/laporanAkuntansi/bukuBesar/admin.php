<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
    $this->breadcrumbs=array(
    'Laporan Buku Besar',
    );
$url = Yii::app()->createUrl('akuntansi/laporanAkuntansi/frameGrafikLaporanBukuBesar&id=1');
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
/*
$('.search-form form').submit(function(){
    $('#Grafik').attr('src','').css('height','0px');
    $.fn.yiiGridView.update('tableLaporan', {
            data: $(this).serialize()
    });
    return false;
});
*/
");
?>
<div class="panel panel-gradient">
	<div class="panel-heading">
		<div class="panel-title">Laporan Buku Besar</div>
	</div>
	<div class="panel-body">

<div class="search-form">
<?php 
$this->renderPartial('akuntansi.views.laporanAkuntansi.bukuBesar/_search',array(
    'model'=>$model,
)); ?>
</div><!-- search-form -->
<div class="panel panel-success">
	<div class="panel-heading" >
        <div class="panel-title">Tabel Buku Besar</div>
	</div>
	<div class="panel-body">
		<?php $this->renderPartial('akuntansi.views.laporanAkuntansi.bukuBesar/_table', array('model'=>$model)); ?>
	</div>
</div>

<?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanBukuBesar');
    $this->renderPartial('akuntansi.views.laporanAkuntansi._footerNoGraph', array('urlPrint'=>$urlPrint, 'url'=>$url)); 
?>
	</div>
</div>