<?php
$this->breadcrumbs=array(
	'Model Antrian'=>array('admin'),
	'Tambah',
);
?>
<!--<div class="white-container">
	<legend class="rim2">Tambah <b>Loket</b></legend>-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Tambah <b>Model Antrian</b></div>
    </div>
    <div class="panel-body">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
    </div>
</div>
<!--</div>-->