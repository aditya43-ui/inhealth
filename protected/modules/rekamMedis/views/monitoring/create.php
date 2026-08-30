<?php
$this->breadcrumbs=array(
	'Monitoringrawatjalan Vs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MonitoringrawatjalanV', 'url'=>array('index')),
	array('label'=>'Manage MonitoringrawatjalanV', 'url'=>array('admin')),
);
?>

<h1>Create MonitoringrawatjalanV</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>