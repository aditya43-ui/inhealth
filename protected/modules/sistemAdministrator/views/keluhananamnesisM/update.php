<div class="row">
  <div class="span12"><legend class="rim">Edit Keluhan Anamnesis</legend><br>
  </div>
</div>
<?php
$this->breadcrumbs=array(
	'Rmkeluhananamnesis Ms'=>array('index'),
	$model->keluhananamnesis_id=>array('view','id'=>$model->keluhananamnesis_id),
	'Update',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Keluhan Anamnesis ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAKeluhananamnesisM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SAKeluhananamnesisM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' SAKeluhananamnesisM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->keluhananamnesis_id))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Keluhan Anamnesis', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

//$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
