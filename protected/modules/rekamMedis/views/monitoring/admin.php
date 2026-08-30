<?php
$this->breadcrumbs=array(
	'Monitoringrawatjalan Vs'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List MonitoringrawatjalanV', 'url'=>array('index')),
	array('label'=>'Create MonitoringrawatjalanV', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('monitoringrawatjalan-v-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Monitoringrawatjalan Vs</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="cari-lanjut search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!--search-form-->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'monitoringrawatjalan-v-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'pasien_id',
		'namadepan',
		'nama_pasien',
		'nama_bin',
		'jeniskelamin',
		'no_rekam_medik',
		/*
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
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
