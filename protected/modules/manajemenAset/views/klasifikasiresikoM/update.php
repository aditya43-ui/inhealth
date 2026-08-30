<?php
$this->breadcrumbs=array(
	'Klasifikasiresiko Ms'=>array('index'),
	$model->klasfikasiresiko_id=>array('view','id'=>$model->klasfikasiresiko_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah KlasifikasiresikoM</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?></div>
