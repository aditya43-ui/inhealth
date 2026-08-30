<?php
$this->breadcrumbs=array(
	' Ts'=>array('index'),
	$model->pengisiansaldoawal_id=>array('view','id'=>$model->pengisiansaldoawal_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PengisiansaldoawalT', 'url'=>array('index')),
	array('label'=>'Create PengisiansaldoawalT', 'url'=>array('create')),
	array('label'=>'View PengisiansaldoawalT', 'url'=>array('view', 'id'=>$model->pengisiansaldoawal_id)),
	array('label'=>'Manage PengisiansaldoawalT', 'url'=>array('admin')),
);
?>
 <div class="panel panel-success panel-shadow">
	<div class="panel-heading">
		<div class="panel-title"><b>Pengisian Saldo Awal</b></div>
	</div>
	<div class="panel-body">
		<div class="panel panel-success panel-shadow">
			<div class="panel-heading">
				<div class="panel-title"><b>Update Pengisian Saldo Awal</b></div>
			</div>
			<div class="panel-body">
				<?php echo $this->renderPartial('_formUpdate', array('model'=>$model, 'ruanganAsal'=>$ruanganAsal,)); ?>
			</div>
		</div>
	</div>
</div>