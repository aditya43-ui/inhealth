<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Diagnosa Keperawatan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'rawatInap/diagnosakeperawatanMRI/Admin')),
        array('label'=>'Rencana Keperawatan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/rencanakeperawatanMRI/Admin')),
    	array('label'=>'Implementasi Keperawatan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/implementasikeperawatanMRI/Admin')),
    	
    		
    ),
));
?>