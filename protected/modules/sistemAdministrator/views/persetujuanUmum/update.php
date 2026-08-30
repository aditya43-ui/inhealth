<?php
$this->breadcrumbs=array(
	'Persetujuanumum Ms'=>array('index'),
	$model->persetujuanumum_id=>array('view','id'=>$model->persetujuanumum_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah PersetujuanumumM</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?></div>
