<?php
$this->breadcrumbs=array(
	'Rmwarna Nomors'=>array('index'),
	$model->warnanomorrm_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Warna Nomor', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAWarnanomorM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SAWarnanomorM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' SAWarnanomorM', 'icon'=>'pencil','url'=>array('update','id'=>$model->warnanomorrm_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' SAWarnanomorM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->warnanomorrm_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Warna Nomor', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'warnanomorrm_id',
		'warnanomorrm_angka',
		'warnanomorrm_warna',
		'warnanomorrm_kodewarna',
                                array(
                                    'label'=>'Aktif',
                                    'value'=>(($model->warnanomorrm_aktif==1)? "Ya" : "Tidak"),
                                )
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>