<?php
$this->breadcrumbs = array(
    'Farakobat Ms' => array('index'),
    $model->rakobat_id => array('view', 'id' => $model->rakobat_id),
    'Update',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Penyimpanan Obat</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form_update', array('model' => $model)); ?>
    </div>
</div>