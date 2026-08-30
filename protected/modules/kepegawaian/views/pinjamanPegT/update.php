
<?php
$this->breadcrumbs=array(
	'PinjamanPeg Ts'=>array('index'),
	$model->pinjamanpeg_id=>array('view','id'=>$model->pinjamanpeg_id),
	'Update',
);

$arrMenu = array();
array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Pinjaman Pegawai ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Pinjaman Pegawai ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
<?php $this->widget('UserTips',array('type'=>'update'));?>