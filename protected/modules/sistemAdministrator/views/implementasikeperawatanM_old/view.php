<?php
$this->breadcrumbs=array(
	'Saimplementasikeperawatan Ms'=>array('index'),
	$model->implementasikeperawatan_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Implementasi Keperawatan', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAImplementasikeperawatanM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SAImplementasikeperawatanM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' SAImplementasikeperawatanM', 'icon'=>'pencil','url'=>array('update','id'=>$model->implementasikeperawatan_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' SAImplementasikeperawatanM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->implementasikeperawatan_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Implementasi Keperawatan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'implementasikeperawatan_id',
		'diagnosakeperawatan_id',
		'rencanakeperawatan_id',
		'implementasikeperawatan_kode',
		'implementasi_nama',
		'iskolaborasiimplementasi',
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>