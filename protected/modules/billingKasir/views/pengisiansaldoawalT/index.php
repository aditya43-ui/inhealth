<?php
$this->breadcrumbs=array(
	' Ts',
);

$this->menu=array(
	array('label'=>'Create PengisiansaldoawalT', 'url'=>array('create')),
	array('label'=>'Manage PengisiansaldoawalT', 'url'=>array('admin')),
);
?>

<h1>Pengisiansaldoawal Ts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
