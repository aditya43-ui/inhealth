<?php 

$module = '/'.$this->module->id;

$menu_list = array(
    array('label'=>'Data Awal', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/catatanDataAwal/index')),
    array('label'=>'Intra Operasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/catatanIntraOperasi/create')),
    array('label'=>'Post Operasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/catatanPostOperasi/create')),
);


$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>$menu_list
));
?>