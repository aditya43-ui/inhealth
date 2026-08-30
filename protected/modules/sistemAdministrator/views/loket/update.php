<?php
$this->breadcrumbs = array(
    'Loket' => array('admin'),
    $model->loket_id => array('view', 'id' => $model->loket_id),
    'Ubah',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Loket</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model)); ?>

    </div>
</div>