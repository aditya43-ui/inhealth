<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Provinsi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'pendaftaranPenjadwalan/propinsiM/Admin')),
        array('label'=>'Kabupaten', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'pendaftaranPenjadwalan/kabupatenM/Admin')),
    	array('label'=>'Kecamatan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'pendaftaranPenjadwalan/kecamatanM/Admin')),
    	array('label'=>'Kelurahan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'pendaftaranPenjadwalan/kelurahanM/Admin')),	
    ),
));
?>