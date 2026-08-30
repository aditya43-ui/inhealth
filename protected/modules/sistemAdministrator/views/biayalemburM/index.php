<?php
$this->breadcrumbs=array(
	'Biayalembur Ms',
);

$this->menu=array(
	array('label'=>'Create BiayalemburM','url'=>array('create')),
	array('label'=>'Manage BiayalemburM','url'=>array('admin')),
);
?>

<h1>Biayalembur Ms</h1>

<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
