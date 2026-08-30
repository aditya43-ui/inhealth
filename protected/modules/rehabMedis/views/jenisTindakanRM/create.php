<?php
$this->breadcrumbs = array(
    'Pengaturan Jenis Tindakan Rehabilitasi Medis' => array('admin'),
    'Tambah Jenis Tindakan Rekam Medis',
);
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>