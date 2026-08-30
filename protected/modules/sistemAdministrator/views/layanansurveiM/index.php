<?php
$this->breadcrumbs=array(
	'Layanansurvei Ms',
);

$this->menu=array(
	array('label'=>'Create LayanansurveiM','url'=>array('create')),
	array('label'=>'Manage LayanansurveiM','url'=>array('admin')),
);
?>

<h1>Layanansurvei Ms</h1>

<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
