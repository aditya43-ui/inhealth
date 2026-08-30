<?php
$this->breadcrumbs=array(
	'Jenis Waktu Ms',
);

$this->menu=array(
	array('label'=>'Create JenisWaktuM', 'url'=>array('create')),
	array('label'=>'Manage JenisWaktuM', 'url'=>array('admin')),
);
?>

<h1>Jenis Waktu Ms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
