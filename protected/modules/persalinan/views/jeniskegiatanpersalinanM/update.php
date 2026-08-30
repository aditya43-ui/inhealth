
<?php
$this->breadcrumbs=array(
	'Psjeniskegiatanpersalinan Ms'=>array('index'),
	$model->lookup_id=>array('view','id'=>$model->lookup_id),
	'Update',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' PSJeniskegiatanpersalinanM #'.$model->lookup_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' PSJeniskegiatanpersalinanM', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' PSJeniskegiatanpersalinanM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' PSJeniskegiatanpersalinanM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->lookup_id))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' PSJeniskegiatanpersalinanM', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
<?php //$this->widget('UserTips',array('type'=>'update'));?>