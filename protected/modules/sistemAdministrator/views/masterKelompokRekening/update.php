<?php
$this->breadcrumbs = array(
    'Pengaturan Kelompok Rekening' => array('admin'),
    $model->kelrekening_id => array('view', 'id' => $model->kelrekening_id),
    'Ubah',
);

?>
<!--div class="white-container"-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Kelompok Rekening</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model)); ?>
    </div>
</div>
<!--/div-->