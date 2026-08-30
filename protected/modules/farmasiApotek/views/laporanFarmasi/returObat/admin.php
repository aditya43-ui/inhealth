<?php
$this->breadcrumbs = array(
    'Laporan Retur Obat',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Retur Obat</b>
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
                //$this->breadcrumbs=array(
                //    'Ppinfo Kunjungan Rjvs'=>array('index'),
                //    'Manage',
                //);

                Yii::app()->clientScript->registerScript('searchTable', "
                            $('#searchLaporan').submit(function(){
                                     $('#tableLaporan').addClass('animation-loading');
                                    $.fn.yiiGridView.update('tableLaporan', {
                                            data: $(this).serialize()
                                    });
                                    return false;
                            });
                            ");

                $url = Yii::app()->createUrl('farmasiApotek/laporanFarmasi/frameGrafikReturObat&id=1');
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
                <?php $this->renderPartial('returObat/_search', array(
                    'model' => $model,
                )); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Retur</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('returObat/_tableReturObat', array('model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Grafik
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
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanReturObat');
        $this->renderPartial('_footer', array('urlPrint' => $urlPrint, 'url' => $url));
        ?>
    </div>
</div>