<?php
$this->breadcrumbs=array(
	'Kppengangkatantphl Ts'=>array('index'),
	$model->pengangkatantphl_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Pengangkatan TPHL ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' KPPengangkatantphlT', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' KPPengangkatantphlT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' KPPengangkatantphlT', 'icon'=>'pencil','url'=>array('update','id'=>$model->pengangkatantphl_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' KPPengangkatantphlT','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->pengangkatantphl_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Pengangkatan TPHL', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'pengangkatantphl_id',
		'pegawai_id',
		'pengangkatantphl_noperjanjian',
		'pengangkatantphl_tmt',
		'pengangkatantphl_tugaspekerjaan',
		'pengangkatantphl_nosk',
		'pengangkatantphl_tglsk',
		'pengangkatantphl_tmtsk',
		'pengangkatantphl_noskterakhir',
		'pengangkatantphl_keterangan',
		'pimpinannama',
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>