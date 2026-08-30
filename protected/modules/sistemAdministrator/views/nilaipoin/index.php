<?php
$this->breadcrumbs=array(
	'Nilaipoin Ms',
);

$this->menu=array(
	array('label'=>'Create NilaipoinM','url'=>array('create')),
	array('label'=>'Manage NilaipoinM','url'=>array('admin')),
);
?>

<h1>Nilaipoin Ms</h1>

<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
