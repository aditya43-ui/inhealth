<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Provinsi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'rawatDarurat/propinsiM/Admin&tab=frame&modul_id='.Yii::app()->session['modul_id'])),
        array('label'=>'Kabupaten', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatDarurat/kabupatenM/Admin&modul_id='.Yii::app()->session['modul_id'])),
    	array('label'=>'Kecamatan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatDarurat/kecamatanM/Admin&modul_id='.Yii::app()->session['modul_id'])),
    	array('label'=>'Kelurahan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatDarurat/kelurahanM/Admin&modul_id='.Yii::app()->session['modul_id'])),	
    ),
));
?>