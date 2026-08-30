<div style="max-height: 200px; overflow: auto;">
    <?php
    $modPendaftaran = new ROPendaftaranT("searchRiwayatPasien");
    $modPendaftaran->pasien_id = (!empty($modPasien->pasien_id) ? $modPasien->pasien_id : -1);
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'riwayatpasien-grid',
        'dataProvider' => $modPendaftaran->searchRiwayatPasien(),
        'template' => "{pager}\n{items}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed table-responsive',
        'columns' => array(
            //                array(
            //                    'header'=>'No.',
            //                    'value' => '$row+1',
            //                    'type'=>'raw',
            //                    'htmlOptions'=>array('style'=>'text-align:right;'),
            //                ),
            array(
                'header' => 'Tgl. Pendaftaran',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
            ),
            array(
                'header' => 'No. Pendaftaran',
                'type' => 'raw',
                'value' => '$data->no_pendaftaran',
            ),
            array(
                'header' => 'Instalasi',
                'type' => 'raw',
                'value' => '$data->instalasi->instalasi_nama',
            ),
            array(
                'header' => 'Poliklinik/Ruangan',
                'type' => 'raw',
                'value' => '$data->ruangan->ruangan_nama',
            ),
            array(
                'header' => 'Dokter',
                'type' => 'raw',
                'value' => '(isset($data->nama_pegawai)?$data->pegawai->nama_pegawai:"")',
            ),
            //                array(
            //                    'header'=>'Jenis Penjamin',
            //                    'type'=>'raw',
            //                    'value'=>'$data->carabayar->carabayar_nama',
            //                ),
            array(
                'header' => 'Penjamin',
                'type' => 'raw',
                'value' => '(isset($data->penjamin)?$data->penjamin->penjamin_nama:"")',
            ),
        ),
    ));
    ?>
</div>