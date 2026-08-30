<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pemakaian Barang</b>
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
            'Transaksi Pemakaian Barang',
        );
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php
        if (!empty($_GET['id'])) {
        ?>
            <?php echo Yii::app()->user->setFlash('success', "Data Pemakaian Barang '.$model->nopemakaianbrg .' berhasil disimpan!"); ?>
        <?php } ?>
        <?php echo $this->renderPartial($this->path_view . '_form', array(
            'model' => $model, 'modDetails' => $modDetails
        )); ?>
    </div>
</div>