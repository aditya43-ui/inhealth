<?php
$this->breadcrumbs=array(
	'Sakelompok Modul Ks',
);

$this->menu=array(
//        array('label'=>Yii::t('mds','List').' Kelompok Modul ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
	array('label'=>Yii::t('mds','Create').' Kelompok Modul', 'icon'=>'file', 'url'=>array('create')),
	array('label'=>Yii::t('mds','Manage').' Kelompok Modul', 'icon'=>'folder-open', 'url'=>array('admin')),
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<?php $this->widget('UserTips',array('type'=>'list'));?>