<?php
    $this->breadcrumbs=array(
        'Laporan Rekap Per Unit Pelayanan',
    );
?>
<?php
//$this->breadcrumbs=array(
//    'Ppinfo Kunjungan Rjvs'=>array('index'),
//    'Manage',
//);

$url = Yii::app()->createUrl('pendaftaranPenjadwalan/laporan/frameGrafikPerUnitPelayanan&id=1');
if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_REKAM_MEDIS){
        $url = Yii::app()->createUrl('rekamMedis/laporan/frameGrafikPerUnitPelayanan&id=1');
    }
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
<?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Rekap Per Unit Pelayanan</b></div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">            
                <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan.unitPelayanan/_searchUnitPelayanan',array(
                    'model'=>$model,'format'=>$format
                )); ?>            
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Rekap Per Unit Pelayanan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan.unitPelayanan/_tableUnitPelayanan', array('model'=>$model)); ?>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
        <i class="fas fa-chart-bar"></i> Grafik
    </div>
            </div>
            <div class="panel-body">
            <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan._tab'); ?>
            <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
            </iframe>        
            </div>
        </div>
        <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanPerUnitPelayanan');
        $this->renderPartial('pendaftaranPenjadwalan.views.laporan._footer', array('urlPrint'=>$urlPrint, 'url'=>$url ,'tips'=>'rekapitulasi')); ?>
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan.rawatJalan/_jsFunctions', array('model'=>$model));?>
    </div>
</div>