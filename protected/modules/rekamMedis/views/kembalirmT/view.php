<?php
$this->breadcrumbs=array(
	'Rkkembalirm Ts'=>array('index'),
	$model->kembalirm_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' RKKembalirmT #'.$model->kembalirm_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RKKembalirmT', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RKKembalirmT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' RKKembalirmT', 'icon'=>'pencil','url'=>array('update','id'=>$model->kembalirm_id))) :  '' ;
                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' RKKembalirmT','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->kembalirm_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' RKKembalirmT', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'kembalirm_id',
		'pengirimanrm_id',
		'pendaftaran_id',
		'peminjamanrm_id',
		'pasien_id',
		'dokrekammedis_id',
		'tglkembali',
		'lengkapdokumenkembali',
		'petugaspenerima',
		'keterangan_pengembalian',
		'ruanganasal_id',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>