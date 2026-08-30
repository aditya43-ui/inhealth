<?php 
$module = '/'.$this->module->id;


$menu_list = array(
    array('label' => 'Asesmen Spiritual Ulang Rawat Inap', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab'=>$this->createUrl('/'.$module.'/asesmenUlang/RI'),'id'=>'ulang-ri')),
    array('label'=>'Asesmen Spiritual Ulang Rawat Jalann/IGD', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->createUrl('/'.$module.'/asesmenUlang/RJRD'), 'id'=>'ulang-rjrd')),
    array('label' => 'Asesmen Awal & Ulang Pasien Ulang', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'window.parent.myAlert("Coming Soon","Perhatian!")', 'id'=>'ulang-pasien-terminal')),
);

$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', 
    'stacked'=>false,
    'items'=>$menu_list
));
?>