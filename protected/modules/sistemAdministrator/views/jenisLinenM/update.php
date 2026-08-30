<?php
$this->breadcrumbs=array(
	'Sajenislinen Ms'=>array('index'),
	$model->jenislinen_id=>array('view','id'=>$model->jenislinen_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah Jenis Linen</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?></div>
