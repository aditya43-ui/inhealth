<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->user_id,
);

$this->menu=array(
        array('label'=>Yii::t('mds','View').' User #'.$model->user_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
	array('label'=>Yii::t('mds','List').' User', 'icon'=>'list', 'url'=>array('index')),
	array('label'=>Yii::t('mds','Create').' User', 'icon'=>'file', 'url'=>array('create')),
        array('label'=>Yii::t('mds','Update').' User', 'icon'=>'pencil','url'=>array('update','id'=>$model->user_id)),
	array('label'=>Yii::t('mds','Delete').' User','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->user_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('mds','Manage').' User', 'icon'=>'folder-open', 'url'=>array('admin')),
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'user_id',
		'username',
		'password',
		'pegawai_id',
		'email',
		'last_login',
		'create_time',
		'create_user_id',
		'update_time',
		'update_user_id',
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>