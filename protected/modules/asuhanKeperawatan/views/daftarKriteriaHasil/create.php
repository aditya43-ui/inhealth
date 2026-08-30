<?php
$this->breadcrumbs = array(
    'Jenisintervensi Ms' => array('index'),
    'Create',
);
?>

<div class="panel panel-gradient">
    <div class="panel panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Daftar Kriteria Hasil</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>