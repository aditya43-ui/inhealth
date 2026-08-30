<?php
$this->breadcrumbs=array(
	'Sadiagnosa Tindakan Ms'=>array('index'),
	$model->diagnosatindakan_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').'  Diagnosa Tindakan #'.$model->diagnosatindakan_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').'  Diagnosa Tindakan', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').'  Diagnosa Tindakan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').'  Diagnosa Tindakan', 'icon'=>'pencil','url'=>array('update','id'=>$model->diagnosatindakan_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').'  Diagnosa Tindakan','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->diagnosatindakan_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').'  Diagnosa Tindakan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'diagnosatindakan_id',
		'diagnosatindakan_kode',
		'diagnosatindakan_nama',
		'diagnosatindakan_namalainnya',
		'diagnosatindakan_katakunci',
		'diagnosatindakan_nourut',
                 array(               // related city displayed as a link
                    'name'=>'diagnosatindakan_aktif',
                    'type'=>'raw',
                    'value'=>(($model->diagnosatindakan_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                ),
		
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>