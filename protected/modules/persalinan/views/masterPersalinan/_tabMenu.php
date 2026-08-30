<?php 

$arr = array(
    array('label'=>'Cara Persalinan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>$this->module->id.'/caraPersalinan/admin')),
    array('label'=>'Jenis Kegiatan Persalinan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->module->id.'/jenisKegiatanPersalinan/admin')),
    array('label'=>'Posisi Janin', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->module->id.'/posisiJanin/admin')),
    array('label'=>'Keadaan Lahir', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->module->id.'/keadaanLahir/admin')),
    array('label'=>'Paritas', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->module->id.'/paritas/admin')),
    array('label'=>'Sebab Kematian', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->module->id.'/sebabKematian/admin')),
);

$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>$arr,
));
?>