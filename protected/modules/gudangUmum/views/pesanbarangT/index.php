<?php
$this->breadcrumbs = array(
    'Transaksi Pemesanan Barang',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pemesanan Barang</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('gudangUmum.views.pesanbarangT._form', array('model' => $model, 'modDetail' => $modDetail)); ?>
    </div>
</div>