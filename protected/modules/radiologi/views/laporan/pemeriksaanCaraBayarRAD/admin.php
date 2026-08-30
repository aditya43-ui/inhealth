<?php
$this->breadcrumbs = array(
    'Laporan Pemeriksaan Jenis Penjamin Radiologi',
);
?>
<!--div class="white-container"-->
<?php
$url = Yii::app()->createUrl('radiologi/laporan/FrameLaporanPemeriksaanCaraBayarRAD&id=1');
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
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Pemeriksaan Jenis Penjamin Radiologi</b>
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
                <fieldset class="">
                    <?php $this->renderPartial('pemeriksaanCaraBayarRAD/_search', array(
                        'model' => $model, 'format' => $format
                    )); ?>
                </fieldset>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pembayaran Pemeriksaan Jenis Penjamin Radiologi</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('pemeriksaanCaraBayarRAD/_table', array('model' => $model)); ?>
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
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintLaporanPemeriksaanCaraBayarRAD');
        $this->renderPartial('_footer_pisah', array('urlPrint' => $urlPrint, 'url' => $url)); ?>
        <?php $this->renderPartial('gizi.views.laporan/_jsFunctions', array('model' => $model)); ?>
    </div>
</div>