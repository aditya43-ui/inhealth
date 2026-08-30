<?php
$this->breadcrumbs=array(
	'Ppbuat Janji Poli Ts'=>array('index'),
	$model->buatjanjipoli_id=>array('view','id'=>$model->buatjanjipoli_id),
	'Update',
);

?>
<legend class="rim2">Ubah PPBuatJanjiPoliT</legend>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
