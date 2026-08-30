<fieldset class="box">
<?php if (!$this->isFrame) : ?>
<legend class="rim2">Tambah Kondisi Keluar</legend>
<?php else: ?>
<legend class="rim">Tambah Kondisi Keluar</legend>
<?php endif; ?>
<?php
$this->breadcrumbs=array(
	'Kondisi Keluar Ms'=>array('index'),
	'Create',
);
?>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
</fieldset>