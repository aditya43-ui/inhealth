<?php $linkHalaman = CustomFunction::getUrlByMenuID(66); ?>
<?php
$this->breadcrumbs = array(
    'Pemesanan Kamar',
); ?>
<div class="panel panel-gradient" id="form-pasien">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Transaksi <b>Pemesanan Kamar</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        if (isset($_GET['status'])) :
            Yii::app()->user->setFlash('success', "Data Pasien " . $model->pasien->namadepan . " " . $model->pasien->nama_pasien . " berhasil disimpan");
        endif;
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php echo $this->renderPartial('_form', array('model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai)); ?>
        <?php echo $this->renderPartial('_jsFunction', array('model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai)); ?>
    </div>
</div>