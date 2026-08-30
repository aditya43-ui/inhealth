<?php
$this->breadcrumbs = array(
    'Pengaturan Jenis Tindakan Rehabilitasi Medis' => array('admin'),
    'Ubah Jenis Tindakan Rekam Medik',
);

$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Jenis Tindakan Rekam Medik</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_formUpdate', array('model' => $model)); ?>
    </div>
</div>