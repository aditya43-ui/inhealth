<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$this->breadcrumbs = array(
    'Laporan Arus Kas',
);

$url = Yii::app()->createUrl('akuntansi/laporanAkuntansi/frameGrafikLaporanBukuBesar&id=1');
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

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Arus Kas</b>
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
                <div class="search-form">
                    <?php $this->renderPartial('akuntansi.views.laporanAkuntansi.aruskas/_search', array('model' => $model));
                    ?>
                </div>
                <!--search-form -->
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Arus Kas</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class='block-tabel'>
                    <?php
                    //                            if (!empty($model->periodeposting_id))
                    $this->renderPartial('akuntansi.views.laporanAkuntansi.aruskas/_tableBaru', array('model' => $model)); ?>
                </div>
            </div>
        </div>

        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanArusKas');
        $this->renderPartial('akuntansi.views.laporanAkuntansi._footerNoGraph', array('urlPrint' => $urlPrint, 'url' => $url));
        ?>

    </div>
</div>