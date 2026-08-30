<?php
$this->breadcrumbs=array(
	'Sainstalasi Ms'=>array('index'),
	$model->instalasi_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Instalasi ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Instalasi', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Instalasi', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Instalasi', 'icon'=>'pencil','url'=>array('update','id'=>$model->instalasi_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Instalasi','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->instalasi_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Instalasi', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'instalasi_id',
		'instalasi_nama',
		'instalasi_namalainnya',
		'instalasi_singkatan',
		'instalasi_lokasi',
                array(               // related city displayed as a link
                    'name'=>'instalasi_aktif',
                    'type'=>'raw',
                    'value'=>(($model->instalasi_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                ),
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>