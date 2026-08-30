<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pengeluaran Aset</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Pengeluaran Aset' => array('index'),
            'Tambah',
        );

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php
        if (!empty($_GET['id'])) {
        ?>
            <?php echo Yii::app()->user->setFlash('success',"Data Pengeluaran Aset berhasil disimpan !"); ?>
        <?php } ?>

        <?php echo $this->renderPartial($this->path_view . '_form', array(
            'model' => $model, 'modDetail' => $modDetail
        )); ?>
    </div>
</div>