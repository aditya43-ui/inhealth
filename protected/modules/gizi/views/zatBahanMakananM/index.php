<?php
$this->breadcrumbs=array(
	'Zat Bahan Makanan Ms',
);

$this->menu=array(
	array('label'=>'Create ZatBahanMakananM', 'url'=>array('create')),
	array('label'=>'Manage ZatBahanMakananM', 'url'=>array('admin')),
);
?>

<h1>Zat Bahan Makanan Ms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
