<?php
$this->breadcrumbs=array(
	'Agsumberanggaran Ms'=>array('index'),
	$model->sumberanggaran_id=>array('view','id'=>$model->sumberanggaran_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah Sumber Anggaran</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?></div>
