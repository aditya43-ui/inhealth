<?php
$this->breadcrumbs=array(
	'Aksesvaskular Ms'=>array('index'),
	$model->aksesvaskular_id=>array('view','id'=>$model->aksesvaskular_id),
	'Update',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Ubah <b>Akses Vaskular</b></div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>
