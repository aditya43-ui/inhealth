<?php 

$module = '/'.$this->module->id;

$menu_list = array(
    array('label'=>'Masuk Ruang Pulih', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/catatanMasukRuangPulih/create')),
    array('label'=>'Observasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/observasiRuangPulih/create')),
    array('label'=>'Medikasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/catatanMedikasi/index')),
    array('label'=>'Keluar Ruang Pulih', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/catatanMasukRuangPulih/keluar')),
    //array('label'=>'Keluar Ruang Pulih', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/keluarRuangPulih/create')),
);


$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>$menu_list
));
?>