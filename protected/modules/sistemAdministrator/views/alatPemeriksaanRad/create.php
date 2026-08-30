<?php
$this->breadcrumbs = array(
    'Sapemeriksaanalatrad Ms' => array('index'),
    'Create',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Tambah Pemeriksaan Radiologi</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model, 'modDetails' => $modDetails)); ?>
    </div>
</div>