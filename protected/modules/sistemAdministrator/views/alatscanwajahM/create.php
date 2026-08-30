<?php
$this->breadcrumbs=array(
    'Alat Scan Wajah'=>array('admin'),
    'Tambah',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Tambah <b>Alat Scan Wajah</b></div>
    </div>
    <div class="panel-body">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        
    </div>
</div>
