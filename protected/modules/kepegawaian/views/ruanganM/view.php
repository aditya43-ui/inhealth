<?php
$this->breadcrumbs=array(
	'Saruangan Ms'=>array('index'),
	$model->ruangan_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Ruangan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Ruangan', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Ruangan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Ruangan', 'icon'=>'pencil','url'=>array('update','id'=>$model->ruangan_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Ruangan','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->ruangan_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Ruangan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'ruangan_id',
		'instalasi.instalasi_nama',
		'ruangan_nama',
		'ruangan_lokasi',
                 array(
                     'label'=>'Kasus Penyakit',
                     'type'=>'raw',
                     'value'=>$this->renderPartial('_kasusPenyakit',array('ruangan_id'=>$model->ruangan_id),true),
                 ),
                 array(
                     'label'=>'Kelas Pelayanan',
                     'type'=>'raw',
                     'value'=>$this->renderPartial('_kelasPelayanan',array('ruangan_id'=>$model->ruangan_id),true),
                 ),
                 array(
                     'label'=>'Daftar Tindakan',
                     'type'=>'raw',
                     'value'=>$this->renderPartial('_daftarTindakan',array('ruangan_id'=>$model->ruangan_id),true),
                 ),
                 array(
                     'label'=>'Pegawai',
                     'type'=>'raw',
                     'value'=>$this->renderPartial('_ruanganPegawai',array('ruangan_id'=>$model->ruangan_id),true),
                 ),
                 array(               // related city displayed as a link
                    'name'=>'ruangan_aktif',
                    'type'=>'raw',
                    'value'=>(($model->ruangan_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                ),
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>