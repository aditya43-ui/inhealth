<?php
$this->breadcrumbs=array(
	'Bahan Diet Ms',
);

$this->menu=array(
	array('label'=>'Create BahandietM', 'url'=>array('create')),
	array('label'=>'Manage BahandietM', 'url'=>array('admin')),
);
?>

<h1>Bahan Diet Ms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
