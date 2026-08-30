
<?php
$this->breadcrumbs=array(
	'Pppasien Ms'=>array('index'),
	'Create',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' PPPasienM ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' PPPasienM', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' PPPasienM', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php $this->widget('UserTips',array('type'=>'create'));?>