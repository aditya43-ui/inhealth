<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(        
        array('label'=>'Keluhan Anamnesis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default', 'onclick'=>'setTab(this);', 'tab'=>'rekamMedis/keluhananamnesisM/admin&tab=frame&modul_id='.Yii::app()->session['modul_id'])), 
        array('label'=>'Keadaan Umum', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/rekamMedis/keadaanumum/admin&modul_id='.Yii::app()->session['modul_id'])),
    	array('label'=>'Body Mass Index', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/rekamMedis/bodyMassIndex/admin&modul_id='.Yii::app()->session['modul_id'])),
        array('label'=>'Sysdia', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/rekamMedis/sysDia/admin&modul_id='.Yii::app()->session['modul_id'])),
    ),
));
?>