<?php
$this->breadcrumbs=array(
	'Alat Absensi EasyLink'=>array('admin'),
	$model->perangkateasylink_id=>array('view','id'=>$model->perangkateasylink_id),
	'Ubah',
);

?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Ubah <b>Alat Absensi EasyLink</b></div>
    </div>
    <div class="panel-body">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

    </div>
</div>
