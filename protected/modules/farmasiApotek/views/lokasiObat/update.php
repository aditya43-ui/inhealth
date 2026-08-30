<?php
$this->breadcrumbs = array(
    'Falokasiobat Ms' => array('index'),
    $model->lokasiobat_id => array('view', 'id' => $model->lokasiobat_id),
    'Update',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Lokasi Obat</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>