<?php
$this->breadcrumbs=array(
	'Konfigurasi Otorisasi Approval'=>array('admin'),
	$model->approvalotorisasi_id,
);

$this->menu=array(
	array('label'=>'List ApprovalotorisasiM','url'=>array('index')),
	array('label'=>'Create ApprovalotorisasiM','url'=>array('create')),
	array('label'=>'Update ApprovalotorisasiM','url'=>array('update','id'=>$model->approvalotorisasi_id)),
	array('label'=>'Delete ApprovalotorisasiM','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->approvalotorisasi_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ApprovalotorisasiM','url'=>array('admin')),
);
?>

<h1>Konfigurasi Otorisasi Approval</h1>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'approvalotorisasi_id',
		'kepalagizi_id',
		'kepalafarmasi_id',
		'kepalaumum_id',
		'kasipersonalia_id',
		'managerumum_id',
		'managerkeuangan_id',
		'direkturrs_id',
		'direkturpt_id',
	),
)); ?>
