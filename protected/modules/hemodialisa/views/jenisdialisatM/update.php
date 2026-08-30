<?php
$this->breadcrumbs=array(
	'Jenisdialisat Ms'=>array('index'),
	$model->jenisdialisat_id=>array('view','id'=>$model->jenisdialisat_id),
	'Update',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Ubah <b>Jenis Dialisat</b></div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>
>>>>>>> 58624a8dfc4c47a8f78b1fa1fa26a38bb1f69113
