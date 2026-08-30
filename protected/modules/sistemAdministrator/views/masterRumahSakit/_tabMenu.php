<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Jenis Rumah Sakit', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default', 'onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/JenisRumahSakit/Admin')),
        array('label'=>'Kepemilikan Rumah Sakit', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/KepemilikanRumahSakit/Admin')),
    	array('label'=>'Kelas Rumah Sakit', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/KelasRumahSakit/Admin')),
    	array('label'=>'Status Penyelenggara Swasta', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/StatusPenyelenggaraSwasta/Admin')),
    	array('label'=>'Tahapan Akreditasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/TahapanAkreditasi/Admin')),
    	array('label'=>'Status Akreditasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/StatusAkreditasi/Admin')),
    ),
));
?>