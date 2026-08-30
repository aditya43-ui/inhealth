<?php
$this->breadcrumbs=array(
	'Ripasienapachescore Ts'=>array('index'),
	$model->pasienapachescore_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' RIPasienapachescoreT #'.$model->pasienapachescore_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RIPasienapachescoreT', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RIPasienapachescoreT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' RIPasienapachescoreT', 'icon'=>'pencil','url'=>array('update','id'=>$model->pasienapachescore_id))) :  '' ;
                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' RIPasienapachescoreT','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->pasienapachescore_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' RIPasienapachescoreT', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'pasienapachescore_id',
		'pasien_id',
		'apachescore_id',
		'pasienadmisi_id',
		'ruangan_id',
		'pegawai_id',
		'pendaftaran_id',
		'tglscoring',
		'gagalginjalakut',
		'point_nama',
		'point_nilai',
		'point_score',
		'paramedis_id',
		'catatanapachescore',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>