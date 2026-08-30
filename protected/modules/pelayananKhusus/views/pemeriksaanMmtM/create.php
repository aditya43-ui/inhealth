<?php
$this->breadcrumbs = array(
    'Skrining' => array('admin'),
    'Create',
);
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Tambah <strong>Master MMT</strong></div>
    </div>
    <div class="panel-body" style="overflow-x: scroll">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>
