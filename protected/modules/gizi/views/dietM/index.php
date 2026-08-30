<?php
$this->breadcrumbs=array(
	'Diet Ms',
);

$this->menu=array(
	array('label'=>'Create DietM', 'url'=>array('create')),
	array('label'=>'Manage DietM', 'url'=>array('admin')),
);
?>

<h1>Diet Ms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
