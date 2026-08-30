<?php
$this->breadcrumbs=array(
	'Sadiagnosa Ms'=>array('index'),
	$model->diagnosa_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Diagnosa ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Diagnosa', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Diagnosa', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Diagnosa', 'icon'=>'pencil','url'=>array('update','id'=>$model->diagnosa_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Diagnosa','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->diagnosa_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Diagnosa', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'diagnosa_id',
		'diagnosa_kode',
		'diagnosa_nama',
		'diagnosa_namalainnya',
		'diagnosa_katakunci',
		'diagnosa_nourut',
		'diagnosa_imunisasi',
                 array(               // related city displayed as a link
                    'name'=>'diagnosa_aktif',
                    'type'=>'raw',
                    'value'=>(($model->diagnosa_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                ),
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>