<?php
$this->breadcrumbs=array(
	'Konfigurasi Otorisasi Approval',
);



$this->menu=array(
	array('label'=>'Create ApprovalotorisasiM','url'=>array('create')),
	array('label'=>'Manage ApprovalotorisasiM','url'=>array('admin')),
);
$this->widget('bootstrap.widgets.BootAlert'); 
?>

<h1>Konfigurasi Otorisasi Approval</h1>

<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
