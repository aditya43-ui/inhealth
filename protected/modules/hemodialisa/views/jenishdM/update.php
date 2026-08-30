<?php
$this->breadcrumbs=array(
	'Jenishd Ms'=>array('index'),
	$model->jenishd_id=>array('view','id'=>$model->jenishd_id),
	'Update',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Ubah <b>Jenis HD</b></div>
    </div>
	<div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
    </div>
</div>
