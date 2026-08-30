<?php
$this->breadcrumbs=array(
	'Lkpemeriksaanlabdet Ms'=>array('index'),
	$model->pemeriksaanlabdet_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' LBPemeriksaanlabdetM #'.$model->pemeriksaanlabdet_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' LBPemeriksaanlabdetM', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' LBPemeriksaanlabdetM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' LBPemeriksaanlabdetM', 'icon'=>'pencil','url'=>array('update','id'=>$model->pemeriksaanlabdet_id))) :  '' ;
                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' LBPemeriksaanlabdetM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->pemeriksaanlabdet_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' LBPemeriksaanlabdetM', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'pemeriksaanlabdet_id',
		'nilairujukan_id',
		'pemeriksaanlab_id',
		'pemeriksaanlabdet_nourut',
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>