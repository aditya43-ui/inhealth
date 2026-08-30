<?php
$this->breadcrumbs = array(
    'Laporan Tindakan Ruangan'
);
?>

<!--<div class="white-container">
    <legend class="rim2">Laporan <b>Pendapatan Ruangan</b></legend>-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Tindakan Ruangan </b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $url = Yii::app()->createUrl('rawatJalan/laporan/frameGrafikLaporanTindakanRuangan&id=1');
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
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('tindakanRuangan/_searchTindakanRuangan', array(
                    'model' => $model, 'format' => $format,
                )); ?>
            </div><!--search-form-->
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel Data <b>Tindakan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('tindakanRuangan/_tableTindakanRuangan', array('model' => $model)); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-chart-bar"></i> Grafik
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_tab'); ?>
                <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
            </div>
        </div>

        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanTindakanRuangan');
        $this->renderPartial('_footer', array('urlPrint' => $urlPrint, 'url' => $url)); ?>
    </div>
</div>