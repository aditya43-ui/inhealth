
<?php
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$template = "{summary}\n{items}\n{pager}";
$sort = true;
$itemsCssClass="table table-striped table-condensed";
if (isset($caraPrint)){
  $data = $model->searchPrint();
  $template = "{items}";
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
                border-spacing:0px;
                padding:0px;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
                
            }
            
        </style>";
    $itemsCssClass = 'table border';
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
} else{
  $data = $model->searchTable();
}
$qty_tindakan_no=0;
$qty_tindakan_yes=0;
$subtotal_no=0;
$subtotal_yes=0;
$tarif_rsakomodasi_no=0;
$tarif_rsakomodasi_yes=0;
$tarif_paramedis_no=0;
$tarif_paramedis_yes=0;
$tarif_medis_yes=0;
$tarif_medis_no=0;
$tarif_bhp_no=0;
$tarif_bhp_yes=0;
foreach($model->searchPrint()->getData() as $load){
//        $qty_tindakan+=$load->qty_tindakan;
        ($load->daftartindakan_karcis == false)?$qty_tindakan_no+=$load->qty_tindakan:$qty_tindakan_yes+=$load->qty_tindakan;
        //($load->daftartindakan_karcis == false)?$qty_tindakan_no+=$data->qty_tindakan:$qty_tindakan_yes+=$data->qty_tindakan;
        ($load->daftartindakan_karcis == false)?$subtotal_no+=$load->qty_tindakan*($load->tarif_rsakomodasi+$load->tarif_medis+$load->tarif_paramedis+$load->tarif_bhp):$subtotal_yes+=$load->qty_tindakan*($load->tarif_rsakomodasi+$load->tarif_medis);
        ($load->daftartindakan_karcis == false)?$tarif_rsakomodasi_no+=$load->tarif_rsakomodasi:$tarif_rsakomodasi_yes+=$load->tarif_rsakomodasi;
        ($load->daftartindakan_karcis == false)?$tarif_paramedis_no+=$load->tarif_paramedis:$tarif_paramedis_yes+=$load->tarif_paramedis;
        ($load->daftartindakan_karcis == false)?$tarif_medis_no+=$load->tarif_medis:$tarif_medis_yes+=$load->tarif_medis;
        ($load->daftartindakan_karcis == false)? $tarif_bhp_no+=$load->tarif_bhp:$tarif_bhp_yes+=$load->tarif_bhp;
       
  }
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'enableSorting'=>$sort,
        'template'=>$template,
        'mergeHeaders'=>array(
            array(
                'name'=>'<center>Tindakan</center>',
                'start'=>6, //indeks kolom 3
                'end'=>11, //indeks kolom 4
            ),
            array(
                'name'=>'<center>Karcis</center>',
                'start'=>13, //indeks kolom 3
                'end'=>16, //indeks kolom 4
            ),
        ),
        'itemsCssClass'=>$itemsCssClass,
	'columns'=>array(
                array(
                    'header' => 'No.',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                    'footer'=>'<b>Total</b>',
                    'footerHtmlOptions'=>array(
                            'style'=>'text-align: right',
                            'align'=>'right',
                            'colspan'=>'5',
                    ),
                    ),
                array(
                    'header'=>'No. Rekam Medik/<br/>Nama Pasien',
                    'value'=> '$data->noRMNamaPasien',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header' => 'No. Pendaftaran/<br/> Kelas Pelayanan',
                    'value'=>'$data->NoPendaftaranKelas',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'name' => 'carabayarPenjamin',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
//                array(
//                    'name' => 'kelaspelayanan_nama',
//                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
//                ),
                array(
                    'name' => 'daftartindakan_nama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? $data->daftartindakan_nama : \'\'',
                ),
                array(
                    'name' => 'qty_tindakan',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? MyFormatter::formatNumberForPrinoutSum($data->qty_tindakan) : \'\'',
                    'footer'=>MyFormatter::formatNumberForPrinoutSum($qty_tindakan_no),
                    'footerHtmlOptions'=>array(
                            'style'=>'text-align: right',
                            'align'=>'right',
                    ),
                    
                ),
                array(
                    'name' => 'tarif_rsakomodasi',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? MyFormatter::formatNumberForPrinoutSum($data->tarif_rsakomodasi) : \'\'',
                    'footer'=>MyFormatter::formatNumberForPrinoutSum($tarif_rsakomodasi_no),
                    'footerHtmlOptions'=>array(
                            'style'=>'text-align: right',
                            'align'=>'right',
                    ),
                    ),
                array(
                    'name' => 'tarif_medis',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? MyFormatter::formatNumberForPrinoutSum($data->tarif_medis) : \'\'',
                    'footer'=>MyFormatter::formatNumberForPrinoutSum($tarif_medis_no),
                    'footerHtmlOptions'=>array(
                            'style'=>'text-align: right',
                            'align'=>'right',
                    ),
                ),
                array(
                    'name' => 'tarif_paramedis',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? MyFormatter::formatNumberForPrinoutSum($data->tarif_paramedis) : \'\'',
                    'footer'=>MyFormatter::formatNumberForPrinoutSum($tarif_paramedis_no),
                    'footerHtmlOptions'=>array(
                            'style'=>'text-align: right',
                            'align'=>'right',
                    ),
                ),
                array(
                    'name' => 'tarif_bhp',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? MyFormatter::formatNumberForPrinoutSum($data->tarif_bhp) : \'\'',
                    'footer'=>MyFormatter::formatNumberForPrinoutSum($tarif_bhp_no),
                    'footerHtmlOptions'=>array(
                            'style'=>'text-align: right',
                            'align'=>'right',
                    ),
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
                    'value'=>'($data->daftartindakan_karcis == false) ? MyFormatter::formatNumberForPrinoutSum($data->qty_tindakan*($data->tarif_rsakomodasi+$data->tarif_medis+$data->tarif_paramedis+$data->tarif_bhp)) : \'\'',
                    'footer'=>MyFormatter::formatNumberForPrinoutSum($subtotal_no),
                    'footerHtmlOptions'=>array(
                            'style'=>'text-align: right',
                            'align'=>'right',
                    ),
                    ),
                array(
                    'name' => 'karcisnama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? \'\' : $data->daftartindakan_nama',
                    'footer'=>'&nbsp;'
                ),
                array(
                    'name' => 'karcisqty',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? \'\' : MyFormatter::formatNumberForPrinoutSum($data->qty_tindakan)',
                    'footer'=>MyFormatter::formatNumberForPrinoutSum($qty_tindakan_yes),
                    'footerHtmlOptions'=>array(
                            'style'=>'text-align: right',
                            'align'=>'right',
                    ),
                ),
                array(
                    'name' => 'karcisrs',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? \'\' : MyFormatter::formatNumberForPrinoutSum($data->tarif_rsakomodasi)',
                    'footer'=>MyFormatter::formatNumberForPrinoutSum($tarif_rsakomodasi_yes),
                    'footerHtmlOptions'=>array(
                            'style'=>'text-align: right',
                            'align'=>'right',
                    ),
                ),
                array(
                    'name' => 'karcismedis',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? \'\' : $data->tarif_medis',
                    'footer'=>MyFormatter::formatNumberForPrinoutSum($tarif_medis_yes),
                    'footerHtmlOptions'=>array(
                            'style'=>'text-align: right',
                            'align'=>'right',
                    ),
                ),
                
                array(
                    'name'=>'subtotal',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value'=>'($data->daftartindakan_karcis == false) ? \'\' : MyFormatter::formatNumberForPrinoutSum($data->qty_tindakan*($data->tarif_rsakomodasi+$data->tarif_medis))',
                    'footer'=>MyFormatter::formatNumberForPrinoutSum($subtotal_yes),
                    'footerHtmlOptions'=>array(
                            'style'=>'text-align: right',
                            'align'=>'right',
                    ),
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