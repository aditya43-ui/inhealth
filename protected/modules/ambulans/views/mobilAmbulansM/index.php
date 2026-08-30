<?php
$this->breadcrumbs=array(
	'Mobil Ambulans Ms',
);

$this->menu=array(
	array('label'=>'Create MobilAmbulansM', 'url'=>array('create')),
	array('label'=>'Manage MobilAmbulansM', 'url'=>array('admin')),
);
?>

<h1>Mobil Ambulans Ms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
