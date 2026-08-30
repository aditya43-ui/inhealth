<?php
$this->breadcrumbs=array(
	'Users',
);

$this->menu=array(
        array('label'=>Yii::t('mds','List').' User ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
	array('label'=>Yii::t('mds','Create').' User', 'icon'=>'file', 'url'=>array('create')),
	array('label'=>Yii::t('mds','Manage').' User', 'icon'=>'folder-open', 'url'=>array('admin')),
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<?php $this->widget('UserTips',array('type'=>'list'));?>