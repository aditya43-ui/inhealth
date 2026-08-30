<?php
$this->breadcrumbs=array(
	'Sadtd Ms'=>array('index'),
	$model->dtd_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Dtd ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Dtd', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Dtd', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Dtd', 'icon'=>'pencil','url'=>array('update','id'=>$model->dtd_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Dtd','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->dtd_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Dtd', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'dtd_id',
		'dtd_noterperinci',
		'dtd_nama',
		'dtd_namalainnya',
		'dtd_katakunci',
		'dtd_nourut',
                 array(               // related city displayed as a link
                    'name'=>'dtd_menular',
                    'type'=>'raw',
                    'value'=>(($model->dtd_menular==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                ),
                  array(               // related city displayed as a link
                    'name'=>'dtd_aktif',
                    'type'=>'raw',
                    'value'=>(($model->dtd_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                ),
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>