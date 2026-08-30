<?php
$this->breadcrumbs = array(
    'Pengaturan Jenis Cuti' => array('admin'),
    $model->jeniscuti_id => array('view', 'id' => $model->jeniscuti_id),
    'Update',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Jenis Cuti</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>