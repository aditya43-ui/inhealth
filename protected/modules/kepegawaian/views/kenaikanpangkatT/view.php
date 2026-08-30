<?php
$this->breadcrumbs=array(
	'Kpkenaikanpangkat Ts'=>array('index'),
	$model->kenaikanpangkat_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' KPKenaikanpangkatT #'.$model->kenaikanpangkat_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' KPKenaikanpangkatT', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' KPKenaikanpangkatT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' KPKenaikanpangkatT', 'icon'=>'pencil','url'=>array('update','id'=>$model->kenaikanpangkat_id))) :  '' ;
                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' KPKenaikanpangkatT','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->kenaikanpangkat_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' KPKenaikanpangkatT', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'kenaikanpangkat_id',
		'realisasikenaikangaji_id',
		'usulankenaikangaji_id',
		'pegawai_id',
		'jabatan',
		'pangkat',
		'keterangan',
		'pimpinannama',
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>