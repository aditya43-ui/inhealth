<?php 
$module = '/'.$this->module->id;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Preventive Maintenance', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTabPemeliharaan(this);', 'tab'=>$module.'/prevmaintenT'.$this->init.'/index')),      
    ),
));
?>