<?php
$this->breadcrumbs=array(
	'Sabahanlinen Ms'=>array('index'),
	$model->bahanlinen_id=>array('view','id'=>$model->bahanlinen_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah Bahan Linen</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model)); ?></div>
