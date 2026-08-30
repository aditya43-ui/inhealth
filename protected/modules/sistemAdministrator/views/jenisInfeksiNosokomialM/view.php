<?php
$this->breadcrumbs=array(
	'Rmjenis Infeksi Nosokomial Ms'=>array('index'),
	$model->jenisin_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jenis Infeksi Nosokomial ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAJenisInfeksiNosokomialM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SAJenisInfeksiNosokomialM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' SAJenisInfeksiNosokomialM', 'icon'=>'pencil','url'=>array('update','id'=>$model->jenisin_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' SAJenisInfeksiNosokomialM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->jenisin_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jenis Infeksi Nosokomial', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'jenisin_id',
		'jenisin_nama',
		'jenisin_namalainnya',
                                array(
                                    'label'=>'Aktif',
                                    'value'=>(($model->jenisin_aktif==1)? "Ya" : "Tidak"),
                                ),
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>