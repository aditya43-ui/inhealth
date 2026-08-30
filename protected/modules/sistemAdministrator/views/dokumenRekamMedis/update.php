<?php
$this->breadcrumbs=array(
	'Sadokrekammedis Ms'=>array('index'),
	$model->dokrekammedis_id=>array('view','id'=>$model->dokrekammedis_id),
	'Update',
);

?>
<legend class="rim2">Ubah Dokumen Rekam Medis</legend>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
