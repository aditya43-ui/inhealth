<div class="row">
  <div class="span12"><legend class="rim">Edit Sebab Infeksi</legend><br>
  </div>
</div>

<?php
$this->breadcrumbs=array(
	'Rmsebab Infeksi Nosokomial Ms'=>array('index'),
	$model->sebabin_id=>array('view','id'=>$model->sebabin_id),
	'Update',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Sebab Infeksi Nosokomial ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SASebabinfeksinosokomialM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SASebabinfeksinosokomialM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' SASebabinfeksinosokomialM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->sebabin_id))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Sebab Infeksi Nosokomial', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

//$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
