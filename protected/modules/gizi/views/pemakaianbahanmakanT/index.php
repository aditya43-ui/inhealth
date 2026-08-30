<?php $linkHalaman = CustomFunction::getUrlByMenuID(3417); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pemakaian Bahan Makanan</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Pemakaian Bahan Makanan',
        );
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php
        if (!empty($_GET['sukses'])) {
        ?>
            <?php echo Yii::app()->user->setFlash('success', "Data Pemakaian Bahan Makanan berhasil disimpan!"); ?>
        <?php } ?>
        <?php echo $this->renderPartial($this->path_view . '_form', array(
            'model' => $model, 'modDetails' => $modDetails
        )); ?>
    </div>
</div>