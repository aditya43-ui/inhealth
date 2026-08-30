<?php
$this->breadcrumbs=array(
	'Coolboxdarah Ms'=>array('index'),
	$model->coolboxdarah_id=>array('view','id'=>$model->coolboxdarah_id),
	'Update',
);

?>
<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Ubah <strong>Cool Box Darah</strong></div>
    </div>
    <div class="panel-body">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
    </div>
</div>