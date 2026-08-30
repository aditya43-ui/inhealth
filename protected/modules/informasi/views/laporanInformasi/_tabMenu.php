<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Rekap Say Hello', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default', 'onclick'=>'setTab(this);', 'tab'=>'informasi/LaporanInformasi/Laporanrekapsayhello/Index')),
        array('label'=>'Rekap Pengaduan Rumah Sakit', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'informasi/LaporanInformasi/Laporanrekappengaduan/Index')),
//        array('label'=>'Rawat Inap', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'billingKasir/Laporan/LaporanPasienPerusahaanRI')),
    ),
));
?>