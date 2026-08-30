<?php
$itemsCssClass = "table table-striped table-condensed";
?>
<?php if (isset($caraPrint)) {
    $data = $model->searchPrint();
    $sort = false;
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
    $sort = true;
}
?>

<?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
    'id' => 'tableLaporan',
    'dataProvider' => $data,
    'enableSorting' => $sort,
    'template' => "{summary}\n{items}\n{pager}",
    'mergeHeaders' => array(
        array(
            'name' => '<p style="margin: 0; text-align: center;">Tarif</p>',
            'start' => 7, //indeks kolom 3
            'end' => 8, //indeks kolom 4
        ),
    ),
    'itemsCssClass' => $itemsCssClass,
    'columns' => array(
        array(
            'header' => 'No.',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
            'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
        ),
        array(
            'name' => 'no_rekam_medik',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(
            'name' => 'nama_pasien',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(
            'name' => 'no_pendaftaran',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(
            'name' => 'nama_pegawai',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(
            'name' => 'carabayarPenjamin',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(
            'header' => 'Kelas Pelayanan',
            'value' => '$data->kelaspelayanan_nama',
            //                    'name'=>'kelaspelayanan_nama',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(
            'header' => 'Tarif Satuan (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->tarif_satuan)',
            //                    'name'=>'tarif_satuan',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(
            'header' => 'Tarif Cyto Tindakan (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->tarifcyto_tindakan)',
            //                    'name'=>'tarifcyto_tindakan',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(
            'header' => 'Tarif RS Akomodasi (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->tarif_rsakomodasi)',
            //                    'name'=>'tarif_rsakomodasi',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(
            'header' => 'Tarif Medis (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->tarif_medis)',
            //                    'name'=>'tarif_medis',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(
            'header' => 'Tarif Paramedis (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->tarif_paramedis)',
            //                    'name'=>'tarif_paramedis',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(
            'header' => 'Tarif BHP (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->tarif_bhp)',
            //                    'name'=>'tarif_bhp',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(
            'header' => 'Total (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->totalTarif)',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:left;'),
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