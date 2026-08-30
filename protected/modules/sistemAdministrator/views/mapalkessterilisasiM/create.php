<?php
$this->breadcrumbs = array(
    'Sterilisasi Alkes' => array('admin'),
    'Create',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Sterilisasi Alkes </b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model)); ?>
        <?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model)); ?>
    </div>
</div>