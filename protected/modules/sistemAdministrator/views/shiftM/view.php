<?php
$this->breadcrumbs=array(
	'Sashift Ms'=>array('index'),
	$model->shift_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Shift #'.$model->shift_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Shift', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Shift', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Shift', 'icon'=>'pencil','url'=>array('update','id'=>$model->shift_id))) :  '' ;
                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Shift','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->shift_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Shift', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'shift_id',
		'shift_nama',
		'shift_namalainnya',
		'shift_jamawal',
		'shift_jamakhir',
		array(            
                                            'label'=>'Aktif',
                                            'type'=>'raw',
                                            'value'=>(($model->shift_aktif==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                                        ),
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>