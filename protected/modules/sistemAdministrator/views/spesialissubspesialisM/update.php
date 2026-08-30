<?php
$this->breadcrumbs=array(
	'Spesialis/Subspesialis'=>array('admin'),
	$model->spesialissubspesialis_id=>array('view','id'=>$model->spesialissubspesialis_id),
	'Ubah',
);

?>
<div class="panel panel-gradient">
	<div class="panel-heading">
		<div class="panel-title">Ubah <b>Spesialis/Subspesialis</b></div>
	</div>
	<div class="panel-body">
		<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		
		<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
	</div>
</div>
