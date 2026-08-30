<?php
$this->breadcrumbs = array(
    'Pengaturan Jadwal Hari Hemodialisa' => array('admin'),
    $model->jadwalhari_id => array('view', 'id' => $model->jadwalhari_id),
    'Update',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Jadwal Hari Hemodialisa</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>