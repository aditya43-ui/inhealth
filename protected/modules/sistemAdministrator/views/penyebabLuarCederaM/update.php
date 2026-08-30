<div class="row">
  <div class="span12"><legend class="rim">Edit Penyebab Luar Cedera</legend><br>
  </div>
</div>

<?php
$this->breadcrumbs=array(
	'Rmpenyebab Luar Cedera Ms'=>array('index'),
	$model->penyebabluarcedera_id=>array('view','id'=>$model->penyebabluarcedera_id),
	'Update',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Penyebab Luar Cedera ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAPenyebabluarcederaM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SAPenyebabluarcederaM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' SAPenyebabluarcederaM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->penyebabluarcedera_id))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Penyebab Luar Cedera', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

//$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
