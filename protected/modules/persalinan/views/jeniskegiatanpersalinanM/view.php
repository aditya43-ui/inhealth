<?php
$this->breadcrumbs=array(
	'Psjeniskegiatanpersalinan Ms'=>array('index'),
	$model->lookup_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' PSJeniskegiatanpersalinanM #'.$model->lookup_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' PSJeniskegiatanpersalinanM', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' PSJeniskegiatanpersalinanM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' PSJeniskegiatanpersalinanM', 'icon'=>'pencil','url'=>array('update','id'=>$model->lookup_id))) :  '' ;
                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' PSJeniskegiatanpersalinanM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->lookup_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' PSJeniskegiatanpersalinanM', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'lookup_id',
		'lookup_type',
		'lookup_name',
		'lookup_value',
		'lookup_urutan',
		'lookup_kode',
		'lookup_aktif',
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>