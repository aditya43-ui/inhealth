<?php
$this->breadcrumbs=array(
	'Nofitikasi Rs'=>array('index'),
	$model->nofitikasi_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Nofitikasi ID:'.$model->nofitikasi_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' NofitikasiR', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' NofitikasiR', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' NofitikasiR', 'icon'=>'pencil','url'=>array('update','id'=>$model->nofitikasi_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' NofitikasiR','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->nofitikasi_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Nofitikasi', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'nofitikasi_id',
		'instalasi_id',
		'modul_id',
		'tglnotifikasi',
		'judulnotifikasi',
		'isinotifikasi',
		'isread',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		'lamahrnotif',
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>