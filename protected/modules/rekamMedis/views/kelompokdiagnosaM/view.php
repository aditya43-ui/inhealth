<?php
$this->breadcrumbs=array(
	'Sakelompok Diagnosa Ms'=>array('index'),
	$model->kelompokdiagnosa_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Kelompok Diagnosa ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kelompok Diagnosa', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kelompok Diagnosa', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Kelompok Diagnosa', 'icon'=>'pencil','url'=>array('update','id'=>$model->kelompokdiagnosa_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Kelompok Diagnosa','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->kelompokdiagnosa_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kelompok Diagnosa', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'kelompokdiagnosa_id',
		'kelompokdiagnosa_nama',
		'kelompokdiagnosa_namalainnya',
		array(            
                                            'label'=>'Aktif',
                                            'type'=>'raw',
                                            'value'=>(($model->kelompokdiagnosa_aktif==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                                        ),
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>