<?php
$itemCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$template = "{summary}\n{items}\n{pager}";
$sort = true;
$data = $model->searchTables();
if (isset($caraPrint)) {
    $sort = false;
    $template = "{items}";
    $data = $model->searchPrint();
    if ($caraPrint == 'EXCEL') {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }

    echo "
            <style>
                .border th, .border td{
                    border:1px solid #000;
                }
                .table thead:first-child{
                    border-top:1px solid #000;        
                }

                thead th{
                    background:none;
                    color:#333;
                }

                .border {
                    box-shadow:none;
                    border-spacing: 0;
                    padding: 0;
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>";
    $itemCssClass = 'table border';
}
$data = $model->searchTables();
?>
<?php $this->widget($table, array(
    'id' => 'tableLaporan',
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    'mergeHeaders' => array(
        //            array(
        //                'name'=>'<p style="margin: 0; text-align: center;">Tindakan</p>',
        //                'start'=>6, //indeks kolom 3
        //                'end'=>11, //indeks kolom 4
        //            ),
        //            array(
        //                'name'=>'<p style="margin: 0; text-align: center;">Karcis</p>',
        //                'start'=>13, //indeks kolom 3
        //                'end'=>16, //indeks kolom 4
        //            ),
    ),
    'itemsCssClass' => $itemCssClass,
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
        ),
        // array(
        //                        'name'=>'pendaftaran_id',
        //                        'value'=>'$data->pendaftaran_id',
        //                        'filter'=>false,
        //                ),s
        array(
            'header' => 'Tanggal Pendaftaran  <br> / No. Pendaftaran',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)." <br> /  ".$data->no_pendaftaran',
        ),
        array(
            'header' => 'Tanggal Meninggal',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_meninggal)',
        ),
        array(
            'header' => 'Nama Pasien',
            'type' => 'raw',
            'value' => '$data->namadepan." ".$data->nama_pasien',
        ),
        array(
            'header' => 'Alamat/<br>RT/RW ',
            'type' => 'raw',
            'value' => '$data->Alamat',
        ),
        array(
            'header' => 'Umur ',
            'type' => 'raw',
            'value' => '$data->umur',
        ),
        array(
            'header' => 'Golongan Umur ',
            'type' => 'raw',
            'value' => '$data->golonganumur_nama',
        ),
        'kondisipulang',
        array(
            'header' => 'Jenis Penjamin/<br>Penjamin ',
            'type' => 'raw',
            'value' => '$data->Carabayar',
        ),
        // 'no_pendaftaran',
        //   'tgl_pendaftaran',
        //  'no_rekam_medik',
        //    'nama_pasien',
        //   'nama_bin',

        // 'jeniskelamin',
        //        'tempat_lahir',
        //  'alamat_pasien',
        //        'no_telepon_pasien',
        //        'no_mobile_pasien',
        //        'anakke',
        //        'jumlah_bersaudara',
        //      'umur',
        //        'tanggal_lahir',
        //        'golongandarah',
        //      'carabayar_nama',
        //      'penjamin_nama',
        //        'kunjungan',
        //        'nama_pegawai',
        //        'ruangan_id',
        //        'ruangan_nama',
        //        'no_urutantri',
        //        'kelompokumur_nama',
        //       'golonganumur_nama',
        //        'carabayar_id',
        //        'penjamin_id',
        //        'kelompokumur_id',
        //        'golonganumur_id',
        //        'statusperiksa',
        //        'pegawai_id',
        //        'propinsi_id',
        //        'propinsi_nama',
        //        'kabupaten_id',
        //        'kabupaten_nama',
        //        'kecamatan_id',
        //        'kecamatan_nama',
        //        'kelurahan_id',
        //        'kelurahan_nama',
        //       'agama',
        //        'statusperkawinan',
        //        'rhesus',
        //        'instalasi_id',
        //        'instalasi_nama',
        //        'caramasuk_id',
        'caramasuk_nama',
        //        'transportasi',

        //        'carakeluar',
        //        'pasienpulang_id',
        //        'pasienadmisi_id',
        //        'tglpasienpulang',
        //      'rt',
        //       'rw',
        //       'tgl_meninggal',
        //        'no_identitas_pasien',
        //        'namadepan',
        //        'penerimapasien',
        //        'lamarawat',
        //        'satuanlamarawat',
        //        'create_time',
        //        'update_time',
        //        'create_loginpemakai_id',
        //        'update_loginpemakai_id',
        //        'create_ruangan',

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>