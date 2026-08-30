<?php
$this->breadcrumbs=array(
	'Kppengangkatanpns Ts'=>array('index'),
	$model->pengangkatanpns_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' KPPengangkatanpnsT #'.$model->pengangkatanpns_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' KPPengangkatanpnsT', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' KPPengangkatanpnsT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' KPPengangkatanpnsT', 'icon'=>'pencil','url'=>array('update','id'=>$model->pengangkatanpns_id))) :  '' ;
                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' KPPengangkatanpnsT','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->pengangkatanpns_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' KPPengangkatanpnsT', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'pengangkatanpns_id',
		'realisasipns_id',
		'usulanpns_id',
		'pegawai_id',
		'perspeng_id',
		'jabatan',
		'pangkat',
		'pendidikan',
		'keterangan',
		'pimpinannama',
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>