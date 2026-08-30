<?php
$this->breadcrumbs=array(
	'Rkpengirimanrm Ts'=>array('index'),
	$model->pengirimanrm_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' RKPengirimanrmT #'.$model->pengirimanrm_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RKPengirimanrmT', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RKPengirimanrmT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' RKPengirimanrmT', 'icon'=>'pencil','url'=>array('update','id'=>$model->pengirimanrm_id))) :  '' ;
                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' RKPengirimanrmT','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->pengirimanrm_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' RKPengirimanrmT', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'pengirimanrm_id',
		'peminjamanrm_id',
		'kembalirm_id',
		'pasien_id',
		'pendaftaran_id',
		'dokrekammedis_id',
		'ruangan_id',
		'nourut_keluar',
		'tglpengirimanrm',
		'kelengkapandokumen',
		'petugaspengirim',
		'printpengiriman',
		'ruanganpengirim_id',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>