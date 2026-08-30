<?php
$itemsCssClass = 'table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$no = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $no = '$row+1';
    $data = $model->searchPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    if ($caraPrint == 'PDF') {
        $table = 'ext.bootstrap.widgets.BootGridViewPDF';
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
    $itemsCssClass = 'table border';
} else {
    $data = $model->searchTable();
    $template = "{summary}\n{items}\n{pager}";
    $sort = true;
}
?>

<?php $this->widget($table, array(
    'id' => 'tableLaporan',
    'dataProvider' => $data,
    'enableSorting' => $sort,
    'template' => $template,
    'mergeHeaders' => array(
        array(
            'name' => '<p style="margin: 0; text-align: center;">Tarif</p>',
            'start' => 7, //indeks kolom 3
            'end' => 12, //indeks kolom 4
        ),
    ),
    'itemsCssClass' => $itemsCssClass,
    'columns' => array(
        array(
            'header' => 'No.',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
            'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1'
        ),
        array(
            'header' => 'Tanggal Pendaftaran/ <br> No. Pendaftaran',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/ <br>".$data->no_pendaftaran'
        ),
        array(
            'name' => 'no_rekam_medik',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(
            'header' => 'Nama Pasien',
            'name' => 'nama_pasien',
            'value' => '$data->namadepan." ".$data->nama_pasien',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),

        array(
            'header' => 'Dokter',
            'value' => function ($data) {
                $p = DokterV::model()->find("pegawai_id = '" . $data->dokterpemeriksa1_id . "' ");

                if (!empty($p)) {
                    return $p->namaLengkap;
                } else {
                    return '-';
                }
            },
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(
            'header' => 'Jenis Penjamin Penjamin',
            'name' => 'carabayarPenjamin',
            'type' => 'raw',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(
            'header' => 'Kelas Pelayanan',
            'value' => '$data->kelaspelayanan_nama',
            //                    'name'=>'kelaspelayanan_nama',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'footer' => '<b>Total</b>',
            'footerHtmlOptions' => array('style' => 'text-align:right;', 'colspan' => 7)
        ),
        array(
            'header' => 'Tarif Satuan (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->tarif_satuan,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'name' => 'tarif_satuan',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(tarif_satuan)'
        ),
        array(
            'header' => 'Tarif Cyto Tindakan (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->tarifcyto_tindakan,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'name' => 'tarifcyto_tindakan',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(tarifcyto_tindakan)'
        ),
        array(
            'header' => 'Tarif RS Akomodasi (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->tarif_rsakomodasi,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'name' => 'tarif_rsakomodasi',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(tarif_rsakomodasi)'
        ),
        array(
            'header' => 'Tarif Medis (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->tarif_medis,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'name' => 'tarif_medis',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(tarif_medis)'
        ),
        array(
            'header' => 'Tarif Paramedis (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->tarif_paramedis,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'name' => 'tarif_paramedis',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(tarif_paramedis)'
        ),
        array(
            'header' => 'Tarif BHP (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->tarif_bhp,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'name' => 'tarif_bhp',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(tarif_bhp)'
        ),
        array(
            'header' => 'Total (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->totalTarif,0,"",".")',
            'name' => 'totalTarif',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(totalTarif)'
        ),

        //                'profilrs_id',
        //                'pasien_id',
        //                'no_rekam_medik',
        //                'tgl_rekam_medik',
        //                'jenisidentitas',
        //                'no_identitas_pasien',
        /*
                'namadepan',
                'nama_pasien',
                'nama_bin',
                'jeniskelamin',
                'tempat_lahir',
                'tanggal_lahir',
                'alamat_pasien',
                'rt',
                'rw',
                'statusperkawinan',
                'agama',
                'golongandarah',
                'rhesus',
                'anakke',
                'jumlah_bersaudara',
                'no_telepon_pasien',
                'no_mobile_pasien',
                'warga_negara',
                'photopasien',
                'alamatemail',
                ////'pendaftaran_id',
                array(
                                'name'=>'pendaftaran_id',
                                'value'=>'$data->pendaftaran_id',
                                'filter'=>false,
                        ),
                'no_pendaftaran',
                'tgl_pendaftaran',
                'umur',
                'no_asuransi',
                'namapemilik_asuransi',
                'nopokokperusahaan',
                'namaperusahaan',
                'tglselesaiperiksa',
                'tindakanpelayanan_id',
                'penjamin_id',
                'penjamin_nama',
                'carabayar_id',
                'carabayar_nama',
                'kelaspelayanan_id',
                'kelaspelayanan_nama',
                'instalasi_id',
                'instalasi_nama',
                'ruangan_id',
                'ruangan_nama',
                'tgl_tindakan',
                'daftartindakan_id',
                'daftartindakan_kode',
                'daftartindakan_nama',
                'tipepaket_id',
                'tipepaket_nama',
                'daftartindakan_karcis',
                'daftartindakan_visite',
                'daftartindakan_konsul',
                'tarif_rsakomodasi',
                'tarif_medis',
                'tarif_paramedis',
                'tarif_bhp',
                
                'tarif_tindakan',
                'satuantindakan',
                'qty_tindakan',
                'cyto_tindakan',
                'tarifcyto_tindakan',
                'discount_tindakan',
                'pembebasan_tindakan',
                'subsidiasuransi_tindakan',
                'subsidipemerintah_tindakan',
                'subsisidirumahsakit_tindakan',
                'iurbiaya_tindakan',
                'create_time',
                'update_time',
                'create_loginpemakai_id',
                'update_loginpemakai_id',
                'create_ruangan',
                'tindakansudahbayar_id',
                'shift_id',
                'shift_nama',
                */
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>