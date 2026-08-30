<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'SK Tarif', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=> '/'.Yii::app()->controller->module->id.'/PerdatarifM'.$this->init.'/admin')),
        array('label'=>'Jenis Tarif', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/'.Yii::app()->controller->module->id.'/JenistarifM'.$this->init.'/admin')),
        array('label'=>'Kelompok Komponen Tarif', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/'.Yii::app()->controller->module->id.'/KelompokkomponentarifM'.$this->init.'/admin')),
    	array('label'=>'Komponen Tarif', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/'.Yii::app()->controller->module->id.'/KomponentarifM'.$this->init.'/admin')),
    	array('label'=>'Nominal Tarif', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/'.Yii::app()->controller->module->id.'/TarifTindakan'.$this->init.'/admin')),
    ),
));
?>