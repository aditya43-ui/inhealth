<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Data Pasien P3</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $table = 'ext.bootstrap.widgets.BootGroupGridView';
        $sort = true;
        $dataProvider = $model->searchPasienP3();
        $template = "{summary}\n{items}\n{pager}";
        ?>
        <?php
        $this->widget(
            $table,
            array(
                'id' => 'tbl_p3',
                'dataProvider' => $dataProvider,
                'template' => $template,
                'enableSorting' => $sort,
                'itemsCssClass' => 'table table-responsive table-bordered table-striped table-condensed',
                'mergeColumns' => array('penjamin_nama'),
                'columns' => array(
                    array(
                        'header' => 'No.',
                        'type' => 'raw',
                        'value' => '$row+1',
                    ),
                    array(
                        'header' => 'Nama Penjamin',
                        'type' => 'raw',
                        'name' => 'penjamin_nama',
                        'value' => '$data->penjamin_nama',
                    ),
                    array(
                        'header' => 'No. Pendaftaran',
                        'type' => 'raw',
                        'value' => '$data->no_pendaftaran',
                    ),
                    array(
                        'header' => 'Tanggal Pendaftaran',
                        'type' => 'raw',
                        'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                    ),
                    array(
                        'header' => 'Nama Lengkap',
                        'type' => 'raw',
                        'value' => '$data->nama_pasien',
                    ),
                    array(
                        'header' => 'Alamat',
                        'type' => 'raw',
                        'value' => '$data->alamat_pasien',
                    ),
                    array(
                        'header' => 'Status Masuk',
                        'type' => 'raw',
                        'value' => '$data->statusmasuk',
                    ),
                    array(
                        'header' => 'Instalasi',
                        'type' => 'raw',
                        'value' => '$data->instalasi_nama',
                    ),
                    array(
                        'header' => 'Ruangan',
                        'type' => 'raw',
                        'value' => '$data->ruangan_nama',
                    ),
                    array(
                        'header' => 'Nama Dokter',
                        'type' => 'raw',
                        'value' => '$data->getNamaDokter()',
                    ),
                    array(
                        'header' => 'Tanggal Pulang',
                        'type' => 'raw',
                        'value' => '$data->getTglKeluar()',
                    ),
                ),
                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
            )
        );
        ?>

    </div>

</div>