<?php 
$module = '/'.$this->module->id;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Preventive Maintenance', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab1(this);', 'tab'=>$module.'/prevmaintenT'.$this->init.'/index')),      
        array('label'=>'Kontrak Pemeliharaan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab1(this);', 'tab'=>$module.'/infoKontrakPemeliharaan'.$this->init.'/index')),
        array('label'=>'Kalibrasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab1(this);', 'tab'=>$module.'/kalibrasi'.$this->init.'/index')),
        array('label'=>'Riwayat Preventive Maintenance', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab1(this);', 'tab'=>$module.'/preventifMaintenanceHistory'.$this->init.'/index')),
        array('label'=>'Riwayat Corrective Maintenance', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab1(this);', 'tab'=>$module.'/correctiveMaintenanceHistory'.$this->init.'/index')),
    ),
));
?>