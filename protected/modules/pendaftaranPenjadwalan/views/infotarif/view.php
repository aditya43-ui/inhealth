<?php
$this->breadcrumbs=array(
	'Pppasien Ms'=>array('index'),
	$model->pasien_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' PPPasienM #'.$model->pasien_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' PPPasienM', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess('Create')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' PPPasienM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                (Yii::app()->user->checkAccess('Update')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' PPPasienM', 'icon'=>'pencil','url'=>array('update','id'=>$model->pasien_id))) :  '' ;
                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' PPPasienM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->pasien_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' PPPasienM', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'pasien_id',
		'pekerjaan_id',
		'kelurahan_id',
		'pendidikan_id',
		'propinsi_id',
		'kecamatan_id',
		'suku_id',
		'profilrs_id',
		'kabupaten_id',
		'no_rekam_medik',
		'tgl_rekam_medik',
		'jenisidentitas',
		'no_identitas_pasien',
		'namadepan',
		'nama_pasien',
		'nama_bin',
		'jeniskelamin',
		'kelompokumur',
		'tempat_lahir',
		'tanggal_lahir',
		'alamat_pasien',
		'rt',
		'rw',
		'statusperkawinan',
		'agama',
		'golongandarah',
		'rhesus',
		'anakke',
		'jumlah_bersaudara',
		'no_telepon_pasien',
		'no_mobile_pasien',
		'warga_negara',
		'photopasien',
		'alamatemail',
		'statusrekammedis',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		'tgl_meninggal',
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>