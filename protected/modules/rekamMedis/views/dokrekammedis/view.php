<?php
$this->breadcrumbs=array(
	'Ppdokrekammedis Ms'=>array('index'),
	$model->dokrekammedis_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Dokumen Rekam Medis #'.$model->dokrekammedis_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Dokumen Rekam Medis', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Dokumen Rekam Medis', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Dokumen Rekam Medis', 'icon'=>'pencil','url'=>array('update','id'=>$model->dokrekammedis_id))) :  '' ;
                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Dokumen Rekam Medis','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->dokrekammedis_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Dokumen Rekam Medis', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'dokrekammedis_id',
		'warnadokrm_id',
		'subrak_id',
		'lokasirak_id',
		'pasien_id',
		'nodokumenrm',
		'tglrekammedis',
		'tglmasukrak',
		'statusrekammedis',
		'tglkeluarakhir',
		'tglmasukakhir',
		'nomortertier',
		'nomorsekunder',
		'nomorprimer',
		'warnanorm_i',
		'warnanorm_ii',
		'tgl_in_aktif',
		'tglpemusnahan',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>