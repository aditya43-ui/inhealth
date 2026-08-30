<?php
$this->breadcrumbs=array(
	'Komponendarah Ms'=>array('index'),
	'Create',
);
?>
<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Tambah <strong>CoolBox Darah</strong></div>
    </div>
    <div class="panel-body">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
	<?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
    </div>
</div>