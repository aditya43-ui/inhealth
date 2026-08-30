<?php
$this->breadcrumbs=array(
	' Ts'=>array('index'),
	$model->pengisiansaldoawal_id,
);

$this->menu=array(
	array('label'=>'List PengisiansaldoawalT', 'url'=>array('index')),
	array('label'=>'Create PengisiansaldoawalT', 'url'=>array('create')),
	array('label'=>'Update PengisiansaldoawalT', 'url'=>array('update', 'id'=>$model->pengisiansaldoawal_id)),
	array('label'=>'Delete PengisiansaldoawalT', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->pengisiansaldoawal_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PengisiansaldoawalT', 'url'=>array('admin')),
);
?>

<h1>View PengisiansaldoawalT #<?php echo $model->pengisiansaldoawal_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'pengisiansaldoawal_id',
		'tglpengisiansaldo',
		'shift_id',
		'nilaisaldoawal',
		'pegawai_id',
		'create_time',
		// 'update_time',
		// 'create_loginpemakai_id',
		// 'update_loginpemakai_id',
		'ruangan_nama',
		'nama_rumahsakit',
		'kirim_tgl',
		// 'kirim_pegawai_id',
		'is_kirim',
	),
)); ?>
