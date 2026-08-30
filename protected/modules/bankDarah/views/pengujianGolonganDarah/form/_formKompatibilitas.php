<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Pengujian Kompatibilitas</b>
        </div>
    </div>
    <div class='panel-body table-responsive'>
        <?php
        $this->renderPartial($this->path_view . 'form/tablePengujian', array(
            'modUjiKompatibilitas' => $modUjiKompatibilitas,
            'modPengujianDarah' => $modPengujianDarah,
            'modPermantaanDetail' => $modPermantaanDetail
        ));
        ?>
    </div>
</div>