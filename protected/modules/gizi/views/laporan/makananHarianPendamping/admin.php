<?php
$this->breadcrumbs = array(
    'Laporan Makanan Harian',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Makanan Harian Pendamping</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $url = Yii::app()->createUrl('rawatJalan/laporan/frameGrafikLaporanMakananHarian&id=1');
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
                <?php
                $this->renderPartial('makananHarianPendamping/_search', array(
                    'model' => $model, 'format' => $format
                ));
                ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel<b> Makanan Harian Pendamping</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('makananHarianPendamping/_table', array('model' => $model)); ?>
            </div>
        </div>

        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanMakananHarianPendamping');
        $this->renderPartial('_footer', array('urlPrint' => $urlPrint, 'url' => $url, 'grafik' => 'none', 'tips' => ''));
        ?>
        <?php $this->renderPartial('gizi.views.laporan/_jsFunctions', array('model' => $model)); ?>
    </div>
</div>