<?php
$this->breadcrumbs=array(
	'Jadwal Makan Ms',
);

$this->menu=array(
	array('label'=>'Create JadwalMakanM', 'url'=>array('create')),
	array('label'=>'Manage JadwalMakanM', 'url'=>array('admin')),
);
?>

<h1>Jadwal Makan Ms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
