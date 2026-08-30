<fieldset class="box">
<?php if (!$this->isFrame) : ?>
<legend class="rim2">Ubah Kondisi Keluar</legend>
<?php else: ?>
<legend class="rim">Ubah Kondisi Keluar</legend>
<?php endif; ?>
<?php
$this->breadcrumbs=array(
	'Kondisi Keluar Ms'=>array('index'),
	$model->kondisikeluar_id=>array('view','id'=>$model->kondisikeluar_id),
	'Update',
);

?>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
</fieldset>