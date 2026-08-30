<?php
$this->breadcrumbs=array(
	'Kpperjalanandinas Rs'=>array('index'),
	$model->perjalanandinas_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Perjalanan Dinas', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' KPPerjalanandinasR', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' KPPerjalanandinasR', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' KPPerjalanandinasR', 'icon'=>'pencil','url'=>array('update','id'=>$model->perjalanandinas_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' KPPerjalanandinasR','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->perjalanandinas_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Perjalanan Dinas', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'perjalanandinas_id',
		'pegawai_id',
		'nourutperj',
		'tujuandinas',
		'tugasdinas',
		'descdinas',
		'alamattujuan',
		'propinsi_nama',
		'kotakabupaten_nama',
		'tglmulaidinas',
		'sampaidengan',
		'negaratujuan',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>