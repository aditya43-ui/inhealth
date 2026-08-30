<?php
$this->breadcrumbs=array(
	'Rmsebab Diagnosa Ms'=>array('index'),
	$model->sebabdiagnosa_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Sebab Diagnosa ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SASebabdiagnosaM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SASebabdiagnosaM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' SASebabdiagnosaM', 'icon'=>'pencil','url'=>array('update','id'=>$model->sebabdiagnosa_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' SASebabdiagnosaM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->sebabdiagnosa_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Sebab Diagnosa', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'sebabdiagnosa_id',
		'jenissebab_id',
		'sebabdiagnosa_nama',
		'sebabdiagnosa_namalainnya',
                                array(
                                    'label'=>'Aktif',
                                    'value'=>(($model->sebabdiagnosa_aktif==1)? "Ya" : "Tidak")
                                ),
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>