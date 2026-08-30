<?php
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
  $data = $model->searchPrint();
  if ($caraPrint=='EXCEL') {
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
} else{
  $data = $model->searchTable();
}
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
//    'filter'=>$model,
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-condensed',
    'columns'=>array(
        array(
            'header' => 'No',
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
        ),
		 array(
            'header' => 'Tanggal Dirujuk',
            'value' => 'isset($data->tgldirujuk) ? MyFormatter::formatDateTimeForUser($data->tgldirujuk) : ""',
            ),
        array(
            'header' => 'No.Pendaftaran/ No.Rekam Medik',
            'value' => '$data->NoPenNoRM',
		),
        array(
            'header' => 'Nama Pasien',
            'value' => '$data->NamaBin',
		),
        array(
            'header' => 'Alamat RT/RW',
            'value' => '$data->alamatRtRw',
		),
        array(
            'header' => 'Jenis kelamin / Umur',
            'value' => '$data->jenisKelaminUmur',
		),
        array(
            'header' => 'Cara bayar/ Penjamin',
            'value' => '$data->caraBayarPenjamin',
		),
        'rumahsakitrujukan',
        array(
            'header' => 'Nama Dokter',
            'value' => '$data->kepadayth',
            ),
        'dirujukkebagian',
        'alasandirujuk',
        /*
        'jeniskelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat_pasien',
        'rt',
        'rw',
        'agama',
        'golongandarah',
        'photopasien',
        'alamatemail',
        'statusrekammedis',
        'statusperkawinan',
        'no_rekam_medik',
        'tgl_rekam_medik',
        ////'pendaftaran_id',
        array(
                        'name'=>'pendaftaran_id',
                        'value'=>'$data->pendaftaran_id',
                        'filter'=>false,
                ),
        'no_pendaftaran',
        'tgl_pendaftaran',
        'no_urutantri',
        'transportasi',
        'keadaanmasuk',
        'statusperiksa',
        'statuspasien',
        'kunjungan',
        'alihstatus',
        'byphone',
        'kunjunganrumah',
        'statusmasuk',
        'umur',
        'no_asuransi',
        'namapemilik_asuransi',
        'nopokokperusahaan',
        'carabayar_id',
        'carabayar_nama',
        'penjamin_id',
        'penjamin_nama',
        'shift_id',
        'ruangan_id',
        'ruangan_nama',
        'instalasi_id',
        'instalasi_nama',
        'jeniskasuspenyakit_id',
        'jeniskasuspenyakit_nama',
        'rujukan_id',
        'carakeluar',
        'kondisipulang',
        'pasienpulang_id',
        'penerimapasien',
        'lamarawat',
        'satuanlamarawat',
        'create_time',
        'update_time',
        'create_loginpemakai_id',
        'update_loginpemakai_id',
        'create_ruangan',
        'tglpasienpulang',
        'pasienbatalpulang_id',
        'rujukankeluar_id',
        
        'alamatrsrujukan',
        'telp_fax',
        'nosuratrujukan',
        
        
        'hasilpemeriksaan_ruj',
        'diagnosasementara_ruj',
        'pengobatan_ruj',
        'lainlain_ruj',
        'catatandokterperujuk',
*/
    ),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 

