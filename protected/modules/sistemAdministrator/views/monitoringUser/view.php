<?php
$this->breadcrumbs=array(
	'Loginpemakai Ks'=>array('index'),
	$model->loginpemakai_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' LoginpemakaiK #'.$model->loginpemakai_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' LoginpemakaiK', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' LoginpemakaiK', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' LoginpemakaiK', 'icon'=>'pencil','url'=>array('update','id'=>$model->loginpemakai_id))) :  '' ;
                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' LoginpemakaiK','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->loginpemakai_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' LoginpemakaiK', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'loginpemakai_id',
		'pegawai_id',
		'pasien_id',
		'nama_pemakai',
		'katakunci_pemakai',
		'lastlogin',
		'tglpembuatanlogin',
		'tglupdatelogin',
		'statuslogin',
		'photouser',
		'loginpemakai_create',
		'loginpemakai_update',
		'loginpemakai_aktif',
		'ruanganaktifitas',
		'crudaktifitas',
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>