<?php
$this->breadcrumbs=array(
	'Sapemeriksaanalatrad Ms'=>array('index'),
	$model->pemeriksaanalatrad_id=>array('view','id'=>$model->pemeriksaanalatrad_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah Alat Radiologi</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?></div>
