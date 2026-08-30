<?php
$this->breadcrumbs=array(
	'Monitoringrawatjalan Vs'=>array('index'),
	$model->pasien_id,
);

$this->menu=array(
	array('label'=>'List MonitoringrawatjalanV', 'url'=>array('index')),
	array('label'=>'Create MonitoringrawatjalanV', 'url'=>array('create')),
	array('label'=>'Update MonitoringrawatjalanV', 'url'=>array('update', 'id'=>$model->pasien_id)),
	array('label'=>'Delete MonitoringrawatjalanV', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->pasien_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MonitoringrawatjalanV', 'url'=>array('admin')),
);
?>

<h1>View MonitoringrawatjalanV #<?php echo $model->pasien_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'pasien_id',
		'namadepan',
		'nama_pasien',
		'nama_bin',
		'jeniskelamin',
		'no_rekam_medik',
		'pendaftaran_id',
		'no_pendaftaran',
		'tgl_pendaftaran',
		'no_urutantri',
		'statusperiksa',
		'statuspasien',
		'kunjungan',
		'umur',
		'carabayar_id',
		'carabayar_nama',
		'penjamin_id',
		'penjamin_nama',
		'ruangan_id',
		'ruangan_nama',
		'instalasi_id',
		'instalasi_nama',
		'jeniskasuspenyakit_id',
		'jeniskasuspenyakit_nama',
		'kelaspelayanan_id',
		'kelaspelayanan_nama',
		'pembayaranpelayanan_id',
		'alihstatus',
		'pasienbatalperiksa_id',
	),
)); ?>
