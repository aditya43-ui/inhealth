<?php
$this->breadcrumbs=array(
	'Resephd Ms'=>array('index'),
	$model->resephd_id=>array('view','id'=>$model->resephd_id),
	'Update',
);

?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Ubah <b>Paket HD</b></div>
    </div>
	<div class="panel-body">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
        </div>
</div>
