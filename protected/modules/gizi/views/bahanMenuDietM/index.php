<?php
$this->breadcrumbs=array(
	'Bahan Menu Diet Ms',
);

$this->menu=array(
	array('label'=>'Create BahanMenuDietM', 'url'=>array('create')),
	array('label'=>'Manage BahanMenuDietM', 'url'=>array('admin')),
);
?>

<h1>Bahan Menu Diet Ms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
