<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Petunjuk Penggunaan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/PetunjukpenggunaanM/admin')),
        array('label'=>'Detail Petunjuk Penggunaan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/PetunjukPenggunaanDetailM/admin')),
    	
    ),
));
?>