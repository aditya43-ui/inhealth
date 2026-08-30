<?php
$this->breadcrumbs=array(
	'Tarif Ambulans',
);

$this->menu=array(
	array('label'=>'Create TarifAmbulansM', 'url'=>array('create')),
	array('label'=>'Manage TarifAmbulansM', 'url'=>array('admin')),
);
?>

<h1>Tarif Ambulans Ms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
