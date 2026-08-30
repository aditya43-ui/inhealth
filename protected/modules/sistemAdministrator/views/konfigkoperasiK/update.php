<?php
$this->breadcrumbs=array(
	'Konfigkoperasi Ks'=>array('index'),
	$model->konfigkoperasi_id=>array('view','id'=>$model->konfigkoperasi_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah Konfigurasi Koperasi</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?></div>
