<?php $linkHalaman = CustomFunction::getUrlByMenuID(62); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-bookmark"></i> Transaksi <b>Pembuatan Janji Poliklinik</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->breadcrumbs = array(
            'Pembuatan Janji Poliklinik' => array('index'),
            'Tambah',
        ); ?>
        <?php echo $this->renderPartial('_form', array('grid' => $grid, 'model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai, 'modPenjamin' => $modPenjamin)); ?>
        <?php echo $this->renderPartial('_jsFunction', array('model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai)); ?>
    </div>
</div>