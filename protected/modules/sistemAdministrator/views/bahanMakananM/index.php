<?php
$this->breadcrumbs=array(
	'Bahan Makanan Ms',
);

$this->menu=array(
	array('label'=>'Create BahanMakananM', 'url'=>array('create')),
	array('label'=>'Manage BahanMakananM', 'url'=>array('admin')),
);
?>

<h1>Bahan Makanan Ms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
