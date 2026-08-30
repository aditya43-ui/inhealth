<?php
$this->breadcrumbs=array(
    'Alat Scan Wajah'=>array('admin'),
    'Ubah',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Ubah <b>Alat Scan Wajah</b></div>
    </div>
    <div class="panel-body">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        
    </div>
</div>