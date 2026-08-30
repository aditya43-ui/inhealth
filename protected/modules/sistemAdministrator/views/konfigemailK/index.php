<?php
$this->breadcrumbs=array(
	'Konfigemail Ks',
);

$this->menu=array(
	array('label'=>'Create KonfigemailK','url'=>array('create')),
	array('label'=>'Manage KonfigemailK','url'=>array('admin')),
);
?>

<h1>Konfigemail Ks</h1>

<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
