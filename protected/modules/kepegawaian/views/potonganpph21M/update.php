<?php
$this->breadcrumbs = array(
    'Pengaturan Potongan PPh 21' => array('admin'),
    $model->potonganpph21_id => array('view', 'id' => $model->potonganpph21_id),
    'Update',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Potongan PPh 21</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>