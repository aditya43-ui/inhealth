<?php
$this->breadcrumbs = array(
    'Laporan 10 Besar Penyakit'
);
?>
<!--<div class="white-container">
    <legend class="rim2">Laporan <b>10 Besar Penyakit</b></legend>-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>10 Besar Penyakit</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $url = Yii::app()->createUrl('perawatanIntensif/laporan/frameGrafik10BesarPenyakit&id=1');
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
                <?php $this->renderPartial('10Besar/_search10Besar', array(
                    'model' => $model, 'format' => $format
                )); ?>
            </div>
            <!--search-form-->
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>10 Besar Penyakit</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('10Besar/_table10Besar', array('model' => $model)); ?>
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
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporan10BesarPenyakit');
        $this->renderPartial('_footer', array('urlPrint' => $urlPrint, 'url' => $url)); ?>
    </div>
</div>