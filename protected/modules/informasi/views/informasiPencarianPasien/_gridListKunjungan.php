<style>
    #pencarianlistkunjungan-grid table thead tr th {
        vertical-align: middle;
    }
</style>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-user"></i> Data <b>Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <table style="width: 100%;" id="dataPasienKunjungan">
            <tr>
                <td><b>Tgl. Rekam Medik</b></td>
                <td>: <?php echo MyFormatter::formatDateTimeForUser($modPasien->tgl_rekam_medik); ?></td>
                <td><b>Alamat</b></td>
                <td>: <?php echo $modPasien->alamat_pasien; ?></td>
            </tr>

            <tr>
                <td><b>No. Rekam Medik</b></td>
                <td>: <?php echo $modPasien->no_rekam_medik; ?></td>
                <td><b>Pekerjaan</b></td>
                <td>: <?php echo empty($modPasien->pekerjaan_id) ? "-" : $modPasien->pekerjaan->pekerjaan_nama; ?></td>
            </tr>
            <tr>
                <td><b>Nama Pasien</b></td>
                <td>: <?php echo $modPasien->nama_pasien; ?></td>
                <td><b>Agama</b></td>
                <td>: <?php echo $modPasien->agama; ?></td>
            </tr>
            <tr>
                <td><b>Tgl. Lahir</b></td>
                <td>: <?php echo MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir); ?></td>
            </tr>
            <tr>
                <td><b>Jenis Kelamin</b></td>
                <td>: <?php echo $modPasien->jeniskelamin; ?></td>
            </tr>
        </table>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Riwayat Kunjungan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
            'id' => 'pencarianlistkunjungan-grid',
            'mergeHeaders' => array(
                //            0=>array(
                //                'start'=>5,
                //                'end'=>6,
                //                'name'=>'Penunjang',
                //            ), 
                0 => array(
                    'start' => 6,
                    'end' => 9,
                    'name' => 'Tindak Lanjut Ke Rawat Inap',
                )
            ),
            'dataProvider' => $modPendaftaran->searchListKunjungan(),
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                ),
                'no_pendaftaran',
                array(
                    'name' => 'tgl_pendaftaran',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                ),
                array(
                    'name' => 'tglselesaiperiksa',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglselesaiperiksa)',
                ),
                array(
                    'name' => 'ruangan.ruangan_nama',
                    'header' => 'Ruangan/Poliklinik',
                ),
                array(
                    'header' => 'Penunjang',
                    'type' => 'raw',
                    'value' => '$this->grid->owner->renderPartial("' . $this->path_view . '_pasienMasukPenunjang", array("pendaftaran_id"=>$data->pendaftaran_id))',
                ),
                array(
                    'header' => 'Tgl. Admisi',
                    'type' => 'raw',
                    'value' => function ($data) use (&$admisi) {
                        $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id));
                        if (!empty($admisi))
                            return MyFormatter::formatDateTimeForUser($admisi->tgladmisi);
                        return "-";
                    },
                ),
                //'pasienadmisiTs.tgladmisi', 
                array(
                    'header' => 'Ruangan/Kelas Pelayanan',
                    'type' => 'raw',
                    'value' => function ($data) use (&$admisi) {
                        if (!empty($admisi))
                            return $admisi->ruangan->ruangan_nama . " / " . $admisi->kelaspelayanan->kelaspelayanan_nama;
                        return "-";
                    },
                ),
                array(
                    'header' => 'Kamar/No. Bed',
                    'type' => 'raw',
                    'value' => function ($data) use (&$admisi) {
                        if (!empty($admisi) && !empty($admisi->kamarruangan))
                            return $admisi->kamarruangan->kamarruangan_nokamar . " / " . $admisi->kamarruangan->kamarruangan_nobed;
                        return "-";
                    }
                    //'!empty($data->pasienadmisi_id)?($data->pasienadmisi->kamarruangan->kamarruangan_nokamar." / ".$data->pasienadmisiTs->kamarruangan->kamarruangan_nobed):"-"',
                ),
                //'pasienadmisiTs.ruangan.ruangan_nama',
                //'pasienadmisiTs.kelaspelayanan.kelaspelayanan_nama',
                array(
                    'header' => 'Cara Pulang / Kondisi',
                    'type' => 'raw',
                    'value' => '(isset($data->pasienpulang->carakeluar->carakeluar_nama) ? $data->pasienpulang->carakeluar->carakeluar_nama : " - ")." / ".(isset($data->pasienpulang->kondisikeluar->kondisikeluar_nama) ? $data->pasienpulang->kondisikeluar->kondisikeluar_nama : " - ")',
                    'htmlOptions' => array('style' => 'text-align: center;'),
                ),
                'statusperiksa',
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>
</div>