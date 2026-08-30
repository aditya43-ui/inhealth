<?php
$this->breadcrumbs=array(
	'Master MMT'=>array('admin'),
	$model->pemeriksaanmmt_id=>array('view','id'=>$model->pemeriksaanmmt_id),
	'Update',
);

?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Ubah <strong>Master MMT</strong></div>
    </div>
    <div class="panel-body" style="overflow-x: scroll">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>
