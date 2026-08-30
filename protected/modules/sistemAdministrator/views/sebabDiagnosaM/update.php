<div class="row">
  <div class="span12"><legend class="rim">Edit Sebab Diagnosa</legend><br>
  </div>
</div>

<?php
$this->breadcrumbs=array(
	'Rmsebab Diagnosa Ms'=>array('index'),
	$model->sebabdiagnosa_id=>array('view','id'=>$model->sebabdiagnosa_id),
	'Update',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Sebab Diagnosa ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SASebabdiagnosaM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SASebabdiagnosaM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' SASebabdiagnosaM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->sebabdiagnosa_id))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Sebab Diagnosa ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

//$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
