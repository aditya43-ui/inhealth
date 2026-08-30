<?php
$this->breadcrumbs=array(
	'Rmsebab Infeksi Nosokomial Ms'=>array('index'),
	$model->sebabin_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Sebab Infeksi Nosokomial ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SASebabinfeksinosokomialM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SASebabinfeksinosokomialM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' SASebabinfeksinosokomialM', 'icon'=>'pencil','url'=>array('update','id'=>$model->sebabin_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' SASebabinfeksinosokomialM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->sebabin_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Sebab Infeksi Nosokomial', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'sebabin_id',
		'sebabin_nama',
		'sebabin_namalainnya',
                                array(
                                    'label'=>'Aktif',
                                    'value'=>(($model->sebabin_aktif==1)? "Ya" : "Tidak")
                                ),
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>