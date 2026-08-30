<?php
$this->breadcrumbs=array(
	'Rkpeminjamanrm Ts'=>array('index'),
	$model->peminjamanrm_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' RKPeminjamanrmT #'.$model->peminjamanrm_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RKPeminjamanrmT', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RKPeminjamanrmT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' RKPeminjamanrmT', 'icon'=>'pencil','url'=>array('update','id'=>$model->peminjamanrm_id))) :  '' ;
                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' RKPeminjamanrmT','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->peminjamanrm_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' RKPeminjamanrmT', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'peminjamanrm_id',
		'pengirimanrm_id',
		'dokrekammedis_id',
		'pasien_id',
		'pendaftaran_id',
		'kembalirm_id',
		'ruangan_id',
		'nourut_pinjam',
		'tglpeminjamanrm',
		'untukkepentingan',
		'keteranganpeminjaman',
		'tglakandikembalikan',
		'namapeminjam',
		'printpeminjaman',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>