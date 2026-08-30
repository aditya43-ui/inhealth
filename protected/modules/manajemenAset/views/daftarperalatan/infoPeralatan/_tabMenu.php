<?php 
$module = '/'.$this->module->id;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Informasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/infoPeralatan'.$this->init.'/detailinformasi')),
        array('label'=>'Gambar', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/infoPeralatan'.$this->init.'/detailgambar')),       
        array('label'=>'Supporting Items', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/InvpersparepartM'.$this->init.'/index')),       
        array('label'=>'Perizinan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/infoPerizinanT'.$this->init.'/index')),       
        array('label'=>'Dokumen Lain', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/InvperalatandokT'.$this->init.'/index')),       
    ),
));
?>