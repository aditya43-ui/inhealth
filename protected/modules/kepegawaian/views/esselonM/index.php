<?php
$this->breadcrumbs=array(
	'Esselon Ms',
);

$this->menu=array(
	array('label'=>'Create EsselonM', 'url'=>array('create')),
	array('label'=>'Manage EsselonM', 'url'=>array('admin')),
);
?>

<h1>Esselon Ms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
