<?php
$this->breadcrumbs=array(
	'Ritabular List Ms'=>array('index'),
	$model->tabularlist_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Tabular List ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Tabular List', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Tabular List', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Tabular List', 'icon'=>'pencil','url'=>array('update','id'=>$model->tabularlist_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Tabular List','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->tabularlist_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tabular List', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'tabularlist_id',
		'tabularlist_chapter',
		'tabularlist_block',
		'tabularlist_title',
		'tabularlist_revisi',
		'tabularlist_versi',
                array(               // related city displayed as a link
                    'name'=>'tabularlist_aktif',
                    'type'=>'raw',
                    'value'=>(($model->tabularlist_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                ),
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>