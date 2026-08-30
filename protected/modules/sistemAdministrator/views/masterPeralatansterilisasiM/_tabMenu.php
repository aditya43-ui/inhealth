<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Peralatan Sterilisasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>$this->getUrlPeralatanSterilisasi())),
    	array('label'=>'Sterilisasi Barang ', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>$this->getUrlMapBarangSterilisasi())),
        array('label'=>'Sterilisasi Linen', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>$this->getUrlMapLinenSterilisasi())), 
        array('label'=>'Sterilisasi Alkes', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>$this->getUrlMapAlkesSterilisasi())),
    ),
));
