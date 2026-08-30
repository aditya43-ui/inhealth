
<?php
$this->breadcrumbs=array(
	'Ripasienapachescore Ts'=>array('index'),
	$model->pasienapachescore_id=>array('view','id'=>$model->pasienapachescore_id),
	'Update',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' PIPasienapachescoreT #'.$model->pasienapachescore_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' PIPasienapachescoreT', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' PIPasienapachescoreT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' PIPasienapachescoreT', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->pasienapachescore_id))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' PIPasienapachescoreT', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
<?php $this->widget('UserTips',array('type'=>'update'));?>