<?php
$this->breadcrumbs = array(
    'Item Edukasi Transfusi' => array('admin'),
    $model->edukasitransfusiitem_id => array('view', 'id' => $model->edukasitransfusiitem_id),
    'Ubah',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Item Edukasi Transfusi</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>