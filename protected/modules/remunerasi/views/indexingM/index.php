<?php
$this->breadcrumbs=array(
	'Indexing Ms',
);

$this->menu=array(
	array('label'=>'Create IndexingM', 'url'=>array('create')),
	array('label'=>'Manage IndexingM', 'url'=>array('admin')),
);
?>

<h1>Indexing Ms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
