<?php
    $this->breadcrumbs = array(
        'Konfigurasi Laporan Keuangan' => array('admin'),
        'Tambah',
    );

    $arrMenu = array();

    $this->menu = $arrMenu;
    ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Konfigurasi Laporan Keuangan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model)); ?>
    </div>
</div>