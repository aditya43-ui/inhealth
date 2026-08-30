<?php
if(Yii::app()->controller->module->id == "penggajian"){
	$suffix = 'GJ';
}else{
	$suffix = '';
}
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Komponen Gaji','url'=>Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/komponengajiM'.$suffix.'/admin')),
        array('label'=>'Golongan Gaji', 'url'=>Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/GolonganGajiM'.$suffix.'/admin'),'active'=>true),
        array('label'=>'PTKP', 'url'=>Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/PtkpM'.$suffix.'/admin')),
    ),
)); 
?>