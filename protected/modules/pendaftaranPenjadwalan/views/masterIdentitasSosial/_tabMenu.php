<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Pendidikan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default', 'onclick'=>'setTab(this);', 'tab'=>'pendaftaranPenjadwalan/PendidikanM/Admin')),
        array('label'=>'Pekerjaan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'pendaftaranPenjadwalan/PekerjaanM/Admin')),
    	array('label'=>'Suku', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'pendaftaranPenjadwalan/SukuM/Admin')),
    ),
));
?>