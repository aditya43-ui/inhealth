<?php
$this->breadcrumbs=array(
	'Rmsys Dias'=>array('index'),
	$model->sysdia_id=>array('view','id'=>$model->sysdia_id),
	'Update',
);

$arrMenu = array();
  array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Sysdia ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
  // array_push($arrMenu,array('label'=>Yii::t('mds','List').' SASysdiaM', 'icon'=>'list', 'url'=>array('index'))) ;
  // (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SASysdiaM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
  // array_push($arrMenu,array('label'=>Yii::t('mds','View').' SASysdiaM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->sysdia_id))) ;
  (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Sysdia', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

//$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
