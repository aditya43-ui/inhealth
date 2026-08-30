<?php
$this->breadcrumbs=array(
	'Caramasuk Ms'=>array('index'),
	$model->caramasuk_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Cara Masuk', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' CaramasukM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' CaramasukM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' CaramasukM', 'icon'=>'pencil','url'=>array('update','id'=>$model->caramasuk_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' CaramasukM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->caramasuk_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Cara Masuk', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'caramasuk_id',
		'caramasuk_nama',
		'caramasuk_namalainnya',
		 array(
                    'name'=>'<p style="margin: 0; text-align: center;">Status</p>',
                    'value'=>($model->caramasuk_aktif == 1 ) ? "Aktif" : "Tidak Aktif",
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                ),
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>