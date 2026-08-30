<?php
$this->breadcrumbs = array(
    'Laporan Kegiatan Linen',
);
$url = Yii::app()->createUrl('laundry/laporanKegiatanLaundry/FrameGrafikKegiatanLaundry&id=1');
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Kegiatan Linen</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
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
                $this->renderPartial($this->path_view . 'kegiatanLaundry/_searchKegiatanLaundry', array(
                    'model' => $model, 'format' => $format
                ));
                ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Kegiatan Linen</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial($this->path_view . 'kegiatanLaundry/_tableKegiatanLaundry', array('model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-chart-bar"></i> Grafik
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial($this->path_view . 'kegiatanLaundry/_tab'); ?>
                <iframe style="border: none;" class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);">
                </iframe>
            </div>
        </div>

        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanKegiatanLaundry');
        $this->renderPartial($this->path_view . 'kegiatanLaundry/_footer', array('urlPrint' => $urlPrint, 'url'=>$url));
        ?>
        <?php $this->renderPartial($this->path_view . 'kegiatanLaundry/_jsFunctions', array('model' => $model)); ?>
    </div>
</div>