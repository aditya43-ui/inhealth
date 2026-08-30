<?php
$this->breadcrumbs = array(
    'Jenis Pembayarans' => array('admin'),
    'Tambah',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Jenis Pembayaran</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model, 'rekD' => $rekD, 'rekK' => $rekK,)); ?>
    </div>
</div>