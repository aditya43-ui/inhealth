<?php
$this->breadcrumbs = array(
    'Jenisintervensi Ms' => array('index'),
    $model->jenisintervensi_id => array('view', 'id' => $model->jenisintervensi_id),
    'Update',
);
?>

<div class="panel panel-gradient">
    <div class="panel panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Intervensi Keperawatan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>