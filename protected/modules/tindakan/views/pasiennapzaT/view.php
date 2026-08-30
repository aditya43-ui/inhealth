<?php
$this->breadcrumbs=array(
	'Rjpasiennapza Ts'=>array('index'),
	$model->pasiennapza_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Pasien Napza ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RJPasiennapzaT', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RJPasiennapzaT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' RJPasiennapzaT', 'icon'=>'pencil','url'=>array('update','id'=>$model->pasiennapza_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' RJPasiennapzaT','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->pasiennapza_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Pasien Napza', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'pasiennapza_id',
		'detailnapza_id',
		'pendaftaran_id',
		'pasien_id',
		'tglperiksanapza',
		'kunjunganke',
		'metodenapza',
		'keteranganmetode',
		'hasilpemeriksaannapza',
		'catatannapza',
		'lamarehabilitasi',
		'satuanlama',
		'paramedis_id',
		'dokter_id',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>