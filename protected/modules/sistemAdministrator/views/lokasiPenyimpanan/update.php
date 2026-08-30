<?php
$this->breadcrumbs = array(
    'Salokasipenyimpanan Ms' => array('index'),
    $model->lokasipenyimpanan_id => array('view', 'id' => $model->lokasipenyimpanan_id),
    'Update',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Lokasi Penyimpanan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model)); ?>
    </div>
</div>