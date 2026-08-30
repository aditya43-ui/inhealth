<?php
$this->breadcrumbs=array(
	'Gfatc Ms'=>array('index'),
	$model->lookup_id=>array('view','id'=>$model->lookup_id),
	'Update',
);

?>
<legend class="rim">Ubah Tahapan Akreditasi</legend>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
