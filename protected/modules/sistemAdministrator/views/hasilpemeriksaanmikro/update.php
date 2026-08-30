<?php
$this->breadcrumbs = array(
    'Hasil Pemeriksaan' => array('index'),
    $model->hasilpemeriksaanmikro_id => array('view', 'id' => $model->hasilpemeriksaanmikro_id),
    'Update',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Hasil Pemeriksaan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model)); ?>
    </div>
</div>