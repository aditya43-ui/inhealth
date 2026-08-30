<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchTable();
$sort = true;
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
  $sort = false;
  $data = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL")
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'mergeHeaders'=>array(
            array(
                'name'=>'<center>Tarif</center>',
                'start'=>7, //indeks kolom 3
                'end'=>8, //indeks kolom 4
            ),
        ),
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
                array(
                    'header' => 'No',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                ),
                array(
                    'name'=>'no_rekam_medik',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'name'=>'nama_pasien',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'name'=>'no_pendaftaran',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'name'=>'nama_pegawai',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Jenis Penjamin Penjamin',
                    'name'=>'carabayarPenjamin',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'name'=>'kelaspelayanan_nama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'footerHtmlOptions'=>array('colspan'=>7,'style'=>'text-align:right;font-style:italic;'),
                    'footer'=>'Jumlah Total',
                ),
                array(
                    'name'=>'tarif_satuan',
                    'value'=>'"Rp. ".number_format($data->tarif_satuan)',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(tarif_satuan)',
                ),
                array(
                    'name'=>'tarifcyto_tindakan',
                    'value'=>'"Rp. ".number_format($data->tarifcyto_tindakan)',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(tarifcyto_tindakan)',
                ),
                array(
                    'name'=>'tarif_rsakomodasi',
                    'value'=>'"Rp. ".number_format($data->tarif_rsakomodasi)',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(tarif_rsakomodasi)',
                ),
                array(
                    'name'=>'tarif_medis',
                    'value'=>'"Rp. ".number_format($data->tarif_medis)',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(tarif_medis)',
                ),
                array(
                    'name'=>'tarif_paramedis',
                    'value'=>'"Rp. ".number_format($data->tarif_paramedis)',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(tarif_paramedis)',
                ),
                array(
                    'name'=>'tarif_bhp',
                    'value'=>'"Rp. ".number_format($data->tarif_bhp)',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(tarif_bhp)',
                ),
                array(
                    'header'=>'Total',
                    'name'=>'totalTarif',
                    'value'=>'"Rp. ".number_format($data->totalTarif)',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(totalTarif)',
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
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>