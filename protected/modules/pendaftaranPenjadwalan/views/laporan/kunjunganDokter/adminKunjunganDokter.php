<?php
$this->breadcrumbs = array(
    'Laporan Kunjungan Dokter',
);

$url = Yii::app()->createUrl('pendaftaranPenjadwalan/laporan/frameGrafikKunjunganDokter&id=1');
if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_REKAM_MEDIS) {
    $url = Yii::app()->createUrl('rekamMedis/laporan/frameGrafikKunjunganDokter&id=1');
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
<?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); 
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Kunjungan Dokter</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body search-form">
                <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan.kunjunganDokter/_searchKunjunganDokter', array(
                    'model' => $model, 'format' => $format
                )); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Kunjungan Dokter</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan.kunjunganDokter/_tableKunjunganDokter', array('model' => $model)); ?>
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
                <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
            </div>
        </div>

        <?php
        //echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik',array('{icon}'=>'<i class="entypo-chart-area"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'$("#Grafik")[0].contentWindow.test();
        //')); 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanKunjunganDokter');
        $this->renderPartial('pendaftaranPenjadwalan.views.laporan._footer', array('urlPrint' => $urlPrint, 'url' => $url, 'tips' => 'rekapitulasi')); ?>
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan.rawatJalan/_jsFunctions', array('model' => $model)); ?>
    </div>
</div>