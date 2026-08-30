<?php 
$module = '/'.$this->module->id;



$this->widget('bootstrap.widgets.BootMenu', array(
  'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
  'stacked'=>false, // whether this is a stacked menu
  'items'=>array(
     array('label'=>'Tindakan (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'pemulasaranJenazah/tabulasiTindakan/index')), 
     array('label'=>'Laboratorium Patologi Klinik (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/laboratorium/index', 'class' => 'labKlinik')),
     array('label'=>'Patologi Anatomi (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/patologiAnatomiTRI/index', 'class' => 'labPA')),
     array('label'=>'Mikrobiologi Klinik', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/mikrobiologiKlinik/index', 'class' => 'labMikro')),
     array('label'=>'Radiologi (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/radiologiNew/index', 'class' => 'labRadiologi')),
  ),
  'htmlOptions'=>[
    'id'=>'tab-periksa'
]
));


?>

