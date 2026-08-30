<div class="white-container">
    <legend class="rim2">Lihat <b>Penggajian Karyawan</b></legend><?php
$this->breadcrumbs=array(
	'Gjpenggajianpeg Ts'=>array('index'),
	$model->penggajianpeg_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Penggajian Pegawai', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' KPPenggajianpegT', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' KPPenggajianpegT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' KPPenggajianpegT', 'icon'=>'pencil','url'=>array('update','id'=>$model->penggajianpeg_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' KPPenggajianpegT','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->penggajianpeg_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Penggajian Pegawai', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'penggajianpeg_id',
		'pegawai_id',
		'tglpenggajian',
		'nopenggajian',
		'keterangan',
		'mengetahui',
		'menyetujui',
		'totalterima',
		'totalpajak',
		'totalpotongan',
		'penerimaanbersih',
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>
</div>