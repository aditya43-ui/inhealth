
<?php
$this->breadcrumbs=array(
	'Sarencana Keperawatan Ms'=>array('index'),
	$model->rencanakeperawatan_id=>array('view','id'=>$model->rencanakeperawatan_id),
	'Update',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Rencana Keperawatan  ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SARencanaKeperawatanM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SARencanaKeperawatanM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' SARencanaKeperawatanM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->rencanakeperawatan_id))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Rencana Keperawatan ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model, 'modRencanaKeperawatan'=>$modRencanaKeperawatan)); ?>
<?php $this->widget('UserTips',array('type'=>'update'));?>