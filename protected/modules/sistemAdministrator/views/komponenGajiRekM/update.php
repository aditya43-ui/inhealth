<?php
$this->breadcrumbs = array(
    'Rekening Komponen Gaji' => array('admin'),
    $model->komponengajirek_id => array('view', 'id' => $model->komponengajirek_id),
    'Ubah',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Rekening Komponen Gaji</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model)); ?>
    </div>
</div>