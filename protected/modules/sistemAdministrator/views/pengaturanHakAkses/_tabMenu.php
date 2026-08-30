<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Peran Pemakai', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/peranPengguna/admin')),
        array('label'=>'Tugas Pemakai', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/tugasPengguna/admin')),
    	array('label'=>'Akses Pemakai', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/aksesPengguna/admin')),
    ),
));
?>