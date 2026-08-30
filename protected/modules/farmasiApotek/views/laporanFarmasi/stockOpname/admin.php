<?php
$this->breadcrumbs = array(
    'Laporan Stok Opname',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Stok Opname</b>
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
                <?php
                $url = Yii::app()->createUrl('farmasiApotek/laporanFarmasi/frameGrafikStockOpname&id=1');
                Yii::app()->clientScript->registerScript('search', "

                            $('#searchLaporan').submit(function(){
                                $('#Grafik').attr('src','').css('height','0px');
                                $.fn.yiiGridView.update('tableLaporan', {
                                        data: $(this).serialize()
                                });
                                return false;
                            });
                            ");
                ?>

                <?php $this->renderPartial('stockOpname/_search', array(
                    'model' => $model,
                )); ?>

            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Stock Opname</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('stockOpname/_tableStockOpname', array('model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-chart-bar"></i> Grafik
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('_tab'); ?>
                <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
            </div>
        </div>

        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanStockOpname');
        $this->renderPartial('_footer', array('urlPrint' => $urlPrint, 'url' => $url));
        ?>
    </div>
</div>