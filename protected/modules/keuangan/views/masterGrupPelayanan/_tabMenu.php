<?php 
$arr =  array();
$arr = array_merge($arr, array(
    array('label'=>'Grup Layanan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>$this->getUrlGrupLayanan())),
    array('label'=>'Grup Layanan Kasir', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlGrupLayananKasir())),
    array('label'=>'Grup Layanan Kasir Obat dan Alkes', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlGrupLayananKasirOa())),    
));

$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>$arr,
));
?>