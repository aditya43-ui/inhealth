<?php
$this->breadcrumbs=array(
	'Gjpotonganpph21 Ms'=>array('index'),
	$model->potonganpph21_id=>array('view','id'=>$model->potonganpph21_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah Potongan PPh 21</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?></div>
