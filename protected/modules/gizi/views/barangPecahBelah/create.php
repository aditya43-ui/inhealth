<?php
$this->breadcrumbs = array(
    'Barang Pecah Belah'
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', '<b>Berhasil!</b> Data berhasil disimpan.');
}
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Pencatatan Barang Pecah Belah
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_form', array(
            'model' => $model,
            'modDetail' => $modDetail,
            'instalasiTujuans' => $instalasiTujuans,
            'ruanganTujuans' => $ruanganTujuans,
        )); ?>

    </div>
</div>