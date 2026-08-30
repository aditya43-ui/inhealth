<?php
$this->breadcrumbs = array(
    'Transaksi Pencatatan Berkas Rekam Medis',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pencatatan Berkas Rekam Medis</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        if (isset($_GET['sukses'])) {
            if ($_GET['sukses'] == 1) {
                Yii::app()->user->setFlash("success", "Tansaksi Pembuatan Dokumen Rekam Medis Baru berhasil disimpan!");
            }
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial($this->path_view_rm . '_form', array('model' => $model, 'pasien' => $pasien, 'tipe' => $tipe)); ?>
    </div>
</div>