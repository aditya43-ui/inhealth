<?php
$this->breadcrumbs=array(
	'Perhitunganem Ms'=>array('index'),
	$model->perhitunganem_id=>array('view','id'=>$model->perhitunganem_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah PerhitunganemM</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?></div>
