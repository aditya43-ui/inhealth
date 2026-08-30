<?php
$itemCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
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
    $itemCssClass = 'table border';
} else {
    $data = $model->searchTable();
    $template = "{summary}\n{items}\n{pager}";
}
?>

<?php $this->widget($table, array(
    'id' => 'tableLaporan',
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    //    'mergeHeaders'=>array(
    //    array(
    //        'name'=>'<p style="margin: 0; text-align: center;">Tindakan</p>',
    //        'start'=>7, //indeks kolom 3
    //         'end'=>14, //indeks kolom 4
    //    ),
    // array(
    //    'name'=>'<p style="margin: 0; text-align: center;">Karcis</p>',
    //      'start'=>13, //indeks kolom 3
    //      'end'=>16, //indeks kolom 4
    //  ),
    //  ),
    'itemsCssClass' => $itemCssClass,
    'columns' => array(
        array(
            'header' => 'No.',
            'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
            'value' => '$row+1',
            'footer' => ' ',
        ),
        array(
            'header' => 'Tanggal/ <br>No. Pendaftaran',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)." ".$data->no_pendaftaran',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'footer' => ' ',
        ),
        array(
            'header' => 'No. Rekam Medik',
            'value' => '$data->no_rekam_medik',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'footer' => ' ',
        ),
        array(
            'header' => 'Nama Pasien',
            'value' => '$data->namadepan." ".$data->nama_pasien',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'footer' => ' ',
        ),
        array(
            'header' => 'Dokter',
            'value' => function ($data) {
                $pegawai_id = TindakanpelayananT::model()->findByPk($data->tindakanpelayanan_id)->dokterpemeriksa1_id;

                $nama = ROPegawaiM::model()->findByPk($pegawai_id);

                if (!empty($nama)) {
                    return $nama->namaLengkap;
                } else {
                    return '-';
                }
            },
            'footer' => ' ',
        ),
        array(
            'header' => 'Jenis Penjamin/ <br>Penjamin',
            'name' => 'carabayarPenjamin',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'footer' => ' ',
        ),

        array(
            'header' => 'Kelas Pelayanan',
            'value' => '$data->kelaspelayanan_nama',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'footer' => ' ',
        ),
        array(
            'header' => 'Jenis Penjamin / Penjamin',
            'name' => 'carabayarPenjamin',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'footer' => ' ',
        ),
        //                array(
        //                    'name' => 'kelaspelayanan_nama',
        //                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
        //                ),
        array(
            'header' => 'Uraian Tindakan',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'value' => '($data->daftartindakan_karcis == false) ? $data->daftartindakan_nama : \'\'',
            'footer' => '<b>Total</b>',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'header' => 'Jumlah Tindakan',
            'name' => 'qty_tindakan',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'value' => '($data->daftartindakan_karcis == false) ? $data->qty_tindakan : \'\'',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(qty_tindakan)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),
        /*     array(
                    'name' => 'tarif_rsakomodasi',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? number_format($data->tarif_rsakomodasi,0,"",".") : \'\'',
					'htmlOptions' => array('style' => 'text-align: right;'),
					'footer' => 'sum(tarif_rsakomodasi)',
					'footerHtmlOptions' => array('style' => 'text-align:right;')
                ),
                array(
                    'name' => 'tarif_medis',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? number_format($data->tarif_medis,0,"",".") : \'\'',
					'htmlOptions' => array('style' => 'text-align: right;'),
					'footer' => 'sum(tarif_medis)',
					'footerHtmlOptions' => array('style' => 'text-align:right;')
                ),
                array(
                    'name' => 'tarif_paramedis',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? number_format($data->tarif_paramedis,0,"",".") : \'\'',
					'htmlOptions' => array('style' => 'text-align: right;'),
					'footer' => 'sum(tarif_paramedis)',
					'footerHtmlOptions' => array('style' => 'text-align:right;')
                ),
                array(
                    'name' => 'tarif_bhp',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? number_format($data->tarif_bhp,0,"",".") : \'\'',
					'htmlOptions' => array('style' => 'text-align: right;'),
					'footer' => 'sum(tarif_bhp)',
					'footerHtmlOptions' => array('style' => 'text-align:right;')
                ),
//                'daftartindakan_nama',
//                'qty_tindakan',
//                'no_pendaftaran',
//                'carabayarPenjamin',
////                'penjamin_nama',
//                'kelaspelayanan_nama',
//                'tarif_rsakomodasi',
//                'tarif_medis',
//                'tarif_paramedis',
//                'tarif_bhp',
                array(
                    'header'=>'Subtotal',
                    'name'=>'tarif_tindakan',
                //    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value'=>'(($data->daftartindakan_karcis == false) ? number_format($data->tarif_tindakan,0,"",".") : "")',
					'htmlOptions' => array('style' => 'text-align: right;'),
					'footer' => 'sum(tarif_tindakan)',
					'footerHtmlOptions' => array('style' => 'text-align:right;')
                ),*/
        /*   array(
                    'name' => 'karcisnama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? \'\' : $data->daftartindakan_nama',
                ),
                array(
                    'header'=> 'Jumlah',
                    'name' => 'karcisqty',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? \'\' : $data->qty_tindakan',
                ),
                array(
                    'name' => 'karcisrs',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? \'\' : "Rp ".number_format($data->tarif_rsakomodasi)',
                ),
                array(
                    'name' => 'karcismedis',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? \'\' : "Rp ".number_format($data->tarif_medis)',
                ),
                
                array(
                    'header'=>'Sub Total',
                    'name'=>'tarif_tindakan',
                 //   'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value'=>'(($data->daftartindakan_karcis == false) ? "" : "Rp ".number_format($data->tarif_tindakan))',
                ),*/
        //                'subtotal',
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
                'tarif_satuan',
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
                'tarif_satuan',
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