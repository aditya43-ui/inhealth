<?php

$konfig = KonfigsystemK::model()->find();
$module = '/' . $this->module->id;

$items = array(

    array('label' => 'Reseptur (P)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatJalan/reseptur/index')),
    array('label' => 'Laboratorium (P)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatJalan/laboratorium/index')),
    array('label' => 'Radiologi (P)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatJalan/radiologiNew/index')),
    array('label'=>'Tindakan (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab' => 'rawatJalan/tindakan/index')),
    array('label'=>'Catatan Perkembangan Pasien Terintegrasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rekamMedis/CPPTRK/index')),        

);

$this->widget('bootstrap.widgets.BootMenu', array(
    'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked' => false, // whether this is a stacked menu
    'items' => $items,
));
?>