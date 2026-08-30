<?php
$this->breadcrumbs=array(
	'Tipe Diet Ms',
);

$this->menu=array(
	array('label'=>'Create TipeDietM', 'url'=>array('create')),
	array('label'=>'Manage TipeDietM', 'url'=>array('admin')),
);
?>

<h1>Tipe Diet Ms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
