<?php $linkHalaman = CustomFunction::getUrlByMenuID(2442); ?>
<?php
$this->breadcrumbs = array(
	'Personalscoring Ts' => array('index'),
	$model->personalscoring_id,
);
$this->menu = array(
	array('label' => 'List PersonalscoringT', 'url' => array('index')),
	array('label' => 'Create PersonalscoringT', 'url' => array('create')),
	array('label' => 'Update PersonalscoringT', 'url' => array('update', 'id' => $model->personalscoring_id)),
	array('label' => 'Delete PersonalscoringT', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->personalscoring_id), 'confirm' => 'Are you sure you want to delete this item?')),
	array('label' => 'Manage PersonalscoringT', 'url' => array('admin')),
);
?>
<h1>View PersonalscoringT #<?php echo $model->personalscoring_id; ?></h1>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
		'personalscoring_id',
		'pegawai_id',
		'penilaianpegawai_id',
		'tglscoring',
		'periodescoring',
		'sampaidengan',
		'gajipokok',
		'jabatan',
		'pendidikan',
		'totalscore',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
	),
)); ?>