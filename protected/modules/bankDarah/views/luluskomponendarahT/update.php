<?php
$this->breadcrumbs=array(
	'Luluskomponendarah Ts'=>array('index'),
	$model->luluskomponendarah_id=>array('view','id'=>$model->luluskomponendarah_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah LuluskomponendarahT</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form',array('modKantong' => $modKantong,
                        'modKantongDarah' => $modKantongDarah,
			'model'=>$model,)); ?></div>
