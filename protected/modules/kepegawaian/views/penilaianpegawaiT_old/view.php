<?php
$this->breadcrumbs=array(
	'Kppenilaianpegawai Ts'=>array('index'),
	$model->penilaianpegawai_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Penilaian Pegawai', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' KPPenilaianpegawaiT', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' KPPenilaianpegawaiT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' KPPenilaianpegawaiT', 'icon'=>'pencil','url'=>array('update','id'=>$model->penilaianpegawai_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' KPPenilaianpegawaiT','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->penilaianpegawai_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Penilaian Pegawai', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(   
	'data'=>$model,
	'attributes'=>array(
		'penilaianpegawai_id',
		'pegawai_id',
		'tglpenilaian',
		'periodepenilaian',
		'sampaidengan',
		'kesetiaan',
		'prestasikerja',
		'tanggungjawab',
		'ketaatan',
		'kejujuran',
		'kerjasama',
		'prakarsa',
		'kepemimpinan',
		'jumlahpenilaian',
		'nilairatapenilaian',
		'performanceindex',
		'penilaianpegawai_keterangan',
		'keberatanpegawai',
		'tanggal_keberatanpegawai',
		'tanggapanpejabat',
		'tanggal_tanggapanpejabat',
		'keputusanatasan',
		'tanggal_keputusanatasan',
		'lainlain',
		'dibuattanggalpejabat',
		'diterimatanggalpegawai',
		'diterimatanggalatasan',
		'penilainama',
		'penilainip',
		'penilaipangkatgol',
		'penilaijabatan',
		'penilaiunitorganisasi',
		'pimpinannama',
		'pimpinannip',
		'pimpinanpangkatgol',
		'pimpinanjabatan',
		'pimpinanunitorganisasi',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>