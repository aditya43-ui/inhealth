<div class="white-container">
    <legend class="rim2">Ubah <b>Penggajian Karyawan</b></legend>
<?php
$this->breadcrumbs=array(
	'Gjpenggajianpeg Ts'=>array('index'),
	$model->penggajianpeg_id=>array('view','id'=>$model->penggajianpeg_id),
	'Update',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Penggajian Pegawai', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' KPPenggajianpegT', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' KPPenggajianpegT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' KPPenggajianpegT', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->penggajianpeg_id))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Penggajian Pegawai', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial($this->path_view. '_formUpdate',array('model'=>$model)); ?>
<?php // $this->widget('UserTips',array('type'=>'update'));?>
</div>