<?php
$this->breadcrumbs=array(
	'Penyulit Hd Ms',
);

$this->menu=array(
	array('label'=>'Create PenyulitHdM','url'=>array('create')),
	array('label'=>'Manage PenyulitHdM','url'=>array('admin')),
);
?>

<h1>Penyulit Hd Ms</h1>

<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
