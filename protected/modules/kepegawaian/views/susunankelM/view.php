<?php
$this->breadcrumbs=array(
	'Kpsusunankel Ms'=>array('index'),
	$model->susunankel_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Susunan Keluarga ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Susunan Keluarga', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' KPSusunankelM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' KPSusunankelM', 'icon'=>'pencil','url'=>array('update','id'=>$model->susunankel_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Susunan Keluarga','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->susunankel_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Susunan Keluarga', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'susunankel_id',
		'pegawai_id',
		'nourutkel',
		'hubkeluarga',
		'susunankel_nama',
		'susunankel_jk',
		'susunankel_tempatlahir',
		'susunankel_tanggallahir',
		'pekerjaan_nama',
		'pendidikan_nama',
		'susunankel_tanggalpernikahan',
		'susunankel_tempatpernikahan',
		'susunankeluarga_nip',
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>