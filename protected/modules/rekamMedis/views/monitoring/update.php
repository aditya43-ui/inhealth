<?php
$this->breadcrumbs=array(
	'Monitoringrawatjalan Vs'=>array('index'),
	$model->pasien_id=>array('view','id'=>$model->pasien_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MonitoringrawatjalanV', 'url'=>array('index')),
	array('label'=>'Create MonitoringrawatjalanV', 'url'=>array('create')),
	array('label'=>'View MonitoringrawatjalanV', 'url'=>array('view', 'id'=>$model->pasien_id)),
	array('label'=>'Manage MonitoringrawatjalanV', 'url'=>array('admin')),
);
?>

<h1>Update MonitoringrawatjalanV <?php echo $model->pasien_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>