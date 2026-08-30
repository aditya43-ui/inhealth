<?php 

$arr = array(
    array('label'=>'Obat dan Alkes', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>$this->module->id.'/laporan/laporanPenerimaanObatAlkes')),
    array('label'=>'Supplier', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->module->id.'/laporan/laporanPenerimaanObatAlkesSupplier')),
);

$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>$arr,
));
?>