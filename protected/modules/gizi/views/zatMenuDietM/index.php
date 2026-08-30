<?php
$this->breadcrumbs=array(
	'Zat Menu Diet Ms',
);

$this->menu=array(
	array('label'=>'Create ZatMenuDietM', 'url'=>array('create')),
	array('label'=>'Manage ZatMenuDietM', 'url'=>array('admin')),
);
?>

<h1>Zat Menu Diet Ms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
