<?php
$this->breadcrumbs=array(
	'Jenissimpanan Ms'=>array('index'),
	$model->jenissimpanan_id=>array('view','id'=>$model->jenissimpanan_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah Jenis Simpanan</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?></div>
