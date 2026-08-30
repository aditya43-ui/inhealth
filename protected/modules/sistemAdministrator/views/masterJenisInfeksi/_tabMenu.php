<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Jenis Infeksi Nosokomial', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/jenisInfeksiNosokomialM/admin')),
        array('label'=>'Sebab Infeksi Nosokomial', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/sebabInfeksiNosokomialM/admin')),
    	array('label'=>'Sebab Diagnosa', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/sebabDiagnosaM/admin')),
    	array('label'=>'Jenis Sebab', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/jenissebabM/admin')),
    	array('label'=>'Penyebab Luar Cidera', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/penyebabLuarCederaM/admin')),
    	array('label'=>'Morfologi Neoplasma', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/morfologiNeoplasmaM/admin')),
    	array('label'=>'Jenis Ketunaan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/jenisKetunaanM/admin')),

    		
    ),
));
?>