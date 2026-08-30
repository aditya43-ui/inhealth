<?php
$this->breadcrumbs=array(
	'Menu Diet Ms',
);

$this->menu=array(
	array('label'=>'Create MenuDietM', 'url'=>array('create')),
	array('label'=>'Manage MenuDietM', 'url'=>array('admin')),
);
?>

<h1>Menu Diet Ms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
