<?php
$this->breadcrumbs=array(
	'Rmjenis Ketunaan Ms'=>array('index'),
	$model->jenisketunaan_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jenis Ketunaan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAJenisKetunaanM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SAJenisKetunaanM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' SAJenisKetunaanM', 'icon'=>'pencil','url'=>array('update','id'=>$model->jenisketunaan_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' SAJenisKetunaanM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->jenisketunaan_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jenis Ketunaan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'jenisketunaan_id',
		'jenisketunaan_kode',
		'jenisketunaan_nama',
		'jenisketunaan_namalainnya',
                                array(
                                    'label'=>'Aktif',
                                    'value'=>(($model->jenisketurunan_aktif==1)? "Ya" : "Tidak"),
                                )
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>