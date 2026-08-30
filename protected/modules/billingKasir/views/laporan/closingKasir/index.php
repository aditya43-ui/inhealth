<?php
$this->breadcrumbs = array(
    'Laporan Closing Kasir',
);

Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
            $('#Grafik').attr('src','').css('height','0px');
            $.fn.yiiGridView.update('laporanclosingkasir-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Closing Kasir</b>
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
                <!--fieldset class="box search-form"-->
                <?php $this->renderPartial('closingKasir/_search', array('model' => $model)); ?>
                <!--</fieldset>-->
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Closing Kasir</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('closingKasir/_table', array('model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-chart-bar"></i> Grafik
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('billingKasir.views.laporan._tab'); ?>
                <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
            </div>
        </div>

        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanClosingKasir');
        $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/frameGrafikLaporanClosingKasir&id=1');
        $this->renderPartial('billingKasir.views.laporan._footer', array('urlPrint' => $urlPrint, 'url' => $url));
        ?>
    </div>
</div>