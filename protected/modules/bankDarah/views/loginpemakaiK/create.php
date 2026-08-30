<?php if (Yii::app()->user->checkAccess('Create')) { ?>
<?php
$this->breadcrumbs=array(
	'Loginpemakai Ks'=>array('index'),
	'Create',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Login Pemakai ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Login Pemakai', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Login Pemakai', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php $this->widget('UserTips',array('type'=>'create'));?>
<?php }else{ 
                throw new CHttpException(404,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));
             }
?>