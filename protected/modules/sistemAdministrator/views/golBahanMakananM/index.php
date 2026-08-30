<?php
$this->breadcrumbs=array(
	'Gol Bahan Makanan Ms',
);

$this->menu=array(
	array('label'=>'Create GolBahanMakananM', 'url'=>array('create')),
	array('label'=>'Manage GolBahanMakananM', 'url'=>array('admin')),
);
?>

<h1>Gol Bahan Makanan Ms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
