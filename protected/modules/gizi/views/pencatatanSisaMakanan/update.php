<?php
$this->breadcrumbs=array(
	'Sisamakananpasien Ts'=>array('index'),
	$model->sisamakananpasien_id=>array('view','id'=>$model->sisamakananpasien_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah SisamakananpasienT</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?></div>
