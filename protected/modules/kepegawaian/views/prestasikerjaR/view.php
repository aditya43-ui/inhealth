<?php
$this->breadcrumbs=array(
	'Kpprestasikerja Rs'=>array('index'),
	$model->prestasikerja_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Prestasi Kerja', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' KPPrestasikerjaR', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' KPPrestasikerjaR', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' KPPrestasikerjaR', 'icon'=>'pencil','url'=>array('update','id'=>$model->prestasikerja_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' KPPrestasikerjaR','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->prestasikerja_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Prestasi Kerja', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'prestasikerja_id',
		'pegawai_id',
		'tglprestasidiperoleh',
		'nourutprestasi',
		'instansipemberi',
		'pejabatpemberi',
		'namapenghargaan',
		'keteranganprestasi',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>