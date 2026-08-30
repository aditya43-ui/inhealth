<?php
$this->breadcrumbs = array(
    'Pengaturan Hari Libur' => array('admin'),
    $model->harilibur_id => array('view', 'id' => $model->harilibur_id),
    'Update',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Hari Libur</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model, 'format' => $format)); ?>
    </div>
</div>