<?php
$this->breadcrumbs = array(
    'Laporan Pemeriksaan Pembayaran',
);
$url = Yii::app()->createUrl('laboratorium/laporan/frameGrafikPembayaranPemeriksaan&id=1');
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
  $('.search-form').toggle();
  return false;
});
$('#searchLaporan').submit(function(){
  $('#Grafik').attr('src','').css('height','0px');
  $('#tableLaporanPembayaranPemeriksaan').addClass('animation-loading');
  $.fn.yiiGridView.update('tableLaporanPembayaranPemeriksaan', {
    data: $(this).serialize()
  });
  return false;
});
");
?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-newspaper"></i> Laporan <b>Pemeriksaan Pembayaran</b>
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
                            <?php $this->renderPartial(
                                'laboratorium.views.laporan.pembayaranPemeriksaan/_searchPembayaranPemeriksaan',
                                array('model' => $model)
                            ); ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Pembayaran Pemeriksaan</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $this->renderPartial('laboratorium.views.laporan.pembayaranPemeriksaan/_tablePembayaranPemeriksaan', array('model' => $model)); ?>
                    </div>
                </div>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="fas fa-chart-bar"></i> Grafik
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $this->renderPartial('laboratorium.views.laporan._tab'); ?>
                        <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
                    </div>
                </div>

                <?php
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanPembayaranPemeriksaan');
                $this->renderPartial('laboratorium.views.laporan._footer', array('urlPrint' => $urlPrint, 'url' => $url));
                $this->renderPartial('_jsFunctions', array('model' => $model));
                ?>
            </div>
        </div>
    </div>
</div>