<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Tabel Organigram', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>$this->module->id.'/'.$this->id.'/admin')),
        array('label'=>'Struktur Organigram', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->module->id.'/'.$this->id.'/organigram')),
//      SEMENTARA BELUM ADA >>  array('label'=>'List Data', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->module->id.'/'.$this->id.'/list')),
 
    ),
));
?>