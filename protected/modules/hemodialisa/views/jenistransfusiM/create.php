<?php
$this->breadcrumbs=array(
	'Jenistransfusi Ms'=>array('index'),
	'Create',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Tambah <b>Jenis transfusi</b></div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>
