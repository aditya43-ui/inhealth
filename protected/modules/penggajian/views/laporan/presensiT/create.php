
<?php
$this->breadcrumbs=array(
	'Kppresensi Ts'=>array('index'),
	'Create',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>' Presensi ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' KPPresensiT', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' KPPresensiT', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'modPegawai'=>$modPegawai)); ?>
<?php $this->widget('UserTips',array('type'=>'create'));?>