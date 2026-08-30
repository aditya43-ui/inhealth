    <?php
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash("success", "Data Pengujian Kompatibilitas berhasil disimpan!");
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-briefcase"></i> Pengujian Kompatibilitas
            </div>
        </div>
        <div class="panel-body">
            <?php
            $this->breadcrumbs = array(
                'Pengujian Kompatibilitas' => array('index'),
                'Tambah',
            );

            $this->widget('bootstrap.widgets.BootAlert'); ?>
            <?php
            if (!empty($_GET['id'])) {
            ?>
                <?php echo Yii::app()->user->setFlash('success', "Data Pengujian Kompatibilitas Berhasil Disimpan!"); ?>
            <?php } ?>

            <?php
            echo $this->renderPartial($this->path_view . '_form', array(
                'modUjiKompatibilitas' => $modUjiKompatibilitas,
                'format' => $format,
                'modPendaftaran' => $modPendaftaran,
                'modPermintaanDarah' => $modPermintaanDarah,
                'modUjiDarah' => $modUjiDarah,
                'modPengujianDarah' => $modPengujianDarah,
                'modUjiDarahPasien' => $modUjiDarahPasien,
                'modPermantaanDetail' => $modPermantaanDetail
            )); ?>
        </div>
    </div>