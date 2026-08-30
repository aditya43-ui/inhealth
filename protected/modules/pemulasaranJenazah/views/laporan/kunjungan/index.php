<?php
//$this->breadcrumbs=array(
//    'Ppinfo Kunjungan Rjvs'=>array('index'),
//    'Manage',
//);

$url = Yii::app()->createUrl(Yii::app()->controller->module->id.'/laporan/frameGrafikKunjungan&id=1');
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('#searchLaporan').submit(function(){
    $('#Grafik').attr('src','').css('height','0px');
    $.fn.yiiGridView.update('tableLaporan', {
            data: $(this).serialize()
    });
    return false;
});
");
?>
<?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class='panel panel-gradient'>
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Daftar Jenazah</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="box search-form">
                    <?php $this->renderPartial('kunjungan/_search',array(
                        'model'=>$model,'format'=>$format
                    )); ?>
                </div><!--search-form-->
            </div>
        </div>
                
        
        
        <div class='panel panel-success'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Daftar Jenazah</b></div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('kunjungan/_table', array('model'=>$model)); ?>
            </div>
        </div>
        
        <div class='panel panel-success'>
            <div class="panel-heading">
                <div class="panel-title">
        <i class="fas fa-chart-bar"></i> Grafik
    </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_tab'); ?>
                <iframe class='biru' src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);"></iframe>        
            </div>
        </div>
        <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanKunjungan');
        $this->renderPartial('_footer_pisah', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>

        <?php $this->renderPartial('_jsFunctions', array('model'=>$model));?>
    </div>
</div>