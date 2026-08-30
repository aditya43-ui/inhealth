<?php
$this->breadcrumbs=array(
	'Jenisdiet Ms',
);

$this->menu=array(
	array('label'=>'Create JenisdietM', 'url'=>array('create')),
	array('label'=>'Manage JenisdietM', 'url'=>array('admin')),
);
?>

<h1>Jenisdiet Ms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
