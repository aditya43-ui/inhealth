<?php
$this->breadcrumbs = array(
    'LED Display Antrian' => array('admin'),
    $model->papanantrianserialruangan_id => array('view', 'id' => $model->papanantrianserialruangan_id),
    'Update',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>LED Display Antrian</b>
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model)); ?>
    </div>
</div>