<?php
$this->breadcrumbs=array(
	'Jenis Skrining Pasien'=>array('admin'),
	'Ubah',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-cogs"></i> Ubah <b>Jenis Srining Pasien</b>
        </div>
    </div>
    <div class="panel-body">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        
    </div>
</div>