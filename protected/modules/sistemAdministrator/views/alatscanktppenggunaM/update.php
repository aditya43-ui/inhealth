<?php
$this->breadcrumbs=array(
	'Alat Scan E-KTP Pasien'=>array('admin'),
	$model->alatscanktppengguna_id=>array('view','id'=>$model->alatscanktppengguna_id),
	'Ubah',
);

?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Ubah <b>Alat Scan E-KTP Pasien</b>
        </div>
    </div>
    <div class="panel-body">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>
