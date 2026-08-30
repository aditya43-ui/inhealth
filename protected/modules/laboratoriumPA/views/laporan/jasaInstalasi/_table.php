<?php 
    $itemCssClass = 'table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
        
        if ($caraPrint=='PDF') {
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
                border-spacing:0px;
                padding:0px;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
        $itemCssClass = 'table border';
        
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'mergeHeaders'=>array(
            array(
                'name'=>'<center>Tindakan</center>',
                'start'=>7, //indeks kolom 3
                'end'=>13, //indeks kolom 4
            ),
            array(
                'name'=>'<center>Karcis</center>',
                'start'=>14, //indeks kolom 3
                'end'=>18, //indeks kolom 4
            ),
        ),
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
                array(
                    'header'=>'No.',
                    'value' => $row,
                ),
                array(
                    'header' => 'No.Pendaftaran',
                    'value'=>'$data->no_pendaftaran',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'No. Rekam Medik',
                    'value'=> '$data->no_rekam_medik',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Nama Pasien',
                    'value'=> '$data->namadepan." ".$data->nama_pasien',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                
                array(
                    'header'=>'Jenis Penjamin / <br/>Penjamin',
                    'name' => 'carabayarPenjamin',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
            
                array(
                    'header' => 'Kelas Pelayanan',
                    'value'=>'$data->kelaspelayanan_nama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
//                array(
//                    'name' => 'kelaspelayanan_nama',
//                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
//                ),
                
                array(
                    'name' => 'tindakansudahbayar_id',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
					'header'=>'Sudah Bayar',
                    'value'=>'!empty($data->tindakansudahbayar_id) ? \'LUNAS\' : \'BELUM LUNAS\' ',
                ),
                array(
                    'name' => 'daftartindakan_nama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? $data->daftartindakan_nama : \'\'',
                ),
                array(
                    'name' => 'qty_tindakan',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? $data->qty_tindakan : \'\'',
                ),
                array(
                    'name' => 'tarif_rsakomodasi',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? "Rp. ".number_format($data->tarif_rsakomodasi) : \'\'',
                ),
                array(
                    'name' => 'tarif_medis',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? "Rp. ".number_format($data->tarif_medis) : \'\'',
                ),
                array(
                    'name' => 'tarif_paramedis',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? "Rp. ".number_format($data->tarif_paramedis) : \'\'',
                ),
                array(
                    'name' => 'tarif_bhp',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? "Rp. ".number_format($data->tarif_bhp) : \'\'',
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
                    'name'=>'subtotal',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? "Rp. ".number_format($data->qty_tindakan*($data->tarif_rsakomodasi+$data->tarif_medis+$data->tarif_paramedis+$data->tarif_bhp)) : \'\'',
                ),
                array(
                    'name' => 'karcisnama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? \'\' : $data->daftartindakan_nama',
                ),
                array(
                    'name' => 'karcisqty',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? \'\' : $data->qty_tindakan',
                ),
                array(
                    'name' => 'karcisrs',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? \'\' : $data->tarif_rsakomodasi',
                ),
                array(
                    'name' => 'karcismedis',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? \'\' : $data->tarif_medis',
                ),
                
                array(
                    'name'=>'subtotal',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? \'\' : "Rp. ".number_format($data->qty_tindakan*($data->tarif_rsakomodasi+$data->tarif_medis))',
                ),
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
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>