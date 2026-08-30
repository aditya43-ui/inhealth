<?php 
$module = $this->module->id;
$controller = '/'.Yii::app()->controller->id;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Laporan Tahunan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default', 'onclick'=>'setTab(this);', 'tab'=>'bankDarah/laporanTahunan/index')),
        array('label'=>'Laporan Donasi Darah Lengkap', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default', 'onclick'=>'setTab(this);', 'tab'=>'bankDarah/laporanDonasiDarahLengkap/index')),
        array('label'=>'Laporan Jumlah Pendonor', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default', 'onclick'=>'setTab(this);', 'tab'=>'bankDarah/laporanJumlahPendonor/index')),
        array('label'=>'Laporan Jumlah Pendonor Baru / Ulang', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default', 'onclick'=>'setTab(this);', 'tab'=>'bankDarah/laporanJumlahPendonorBaruUlang/index')),
    ),
));
?>

<div>
    <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; overflow-x: scroll;" ></iframe>
</div>