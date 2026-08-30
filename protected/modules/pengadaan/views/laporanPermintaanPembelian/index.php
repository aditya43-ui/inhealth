<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai//mengambil Module yang sedang dipakai
if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GUDANG_UMUM) {

    $url = Yii::app()->createUrl('gudangUmum/laporanPermintaanPembelianGU/FrameGrafikLaporanPermintaanPembelian&id=1');
} else {
    $url = Yii::app()->createUrl('gudangFarmasi/laporan/FrameGrafikLaporanPermintaanPembelian&id=1');
}
Yii::app()->clientScript->registerScript('search', "
$('#search-laporan').submit(function(){
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
            <i class="entypo-newspaper"></i> Laporan <b>Permintaan Pembelian (Obat dan Alkes)</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial($this->path_view . '_search', array('model' => $model, 'format' => $format)); ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Permintaan Pembelian (Obat dan Alkes)</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial($this->path_view . '_table', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-chart-bar"></i> Grafik</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_tab'); ?>
                <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
            </div>

            <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanPermintaanPembelian');
            $this->renderPartial($this->path_view . '_footer', array('urlPrint' => $urlPrint, 'url' => $url));
            ?>
        </div>
    </div>