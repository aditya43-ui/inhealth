<?php
$itemCssClass='table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
  $data = $model->searchPrint();
  if ($caraPrint=='EXCEL') {
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
          $itemCssClass='table border';
  
} else{
  $data = $model->searchTable();
}
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
//    'filter'=>$model,
	'template'=>$template,
	'itemsCssClass'=>$itemCssClass,
    'columns'=>array(
        array(
            'header' => 'No.',
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
        ),
		array(
            'header' => 'Tanggal Di Rujuk',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgldirujuk)',
		),
        array(
            'header' => 'No. Pendaftaran',
            'value' => '$data->no_pendaftaran',
		),
        array(
            'header' => 'No. Rekam Medik',
            'value' => '$data->no_rekam_medik',
		),
        array(
            'header' => 'Nama Pasien',
            'value' => '$data->namadepan." ".$data->nama_pasien',
		),
        array(
            'header' => 'Alamat',
            'value' => '$data->alamat_pasien',
		),
        array(
            'header' => 'Umur',
            'value' => '$data->umur',
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
        array(
            'header' => 'Dirujuk Kebagian',
            'value' => '$data->dirujukkebagian',
            ),
        array(
            'header' => 'Alasan Dirujuk',
            'value' => '$data->alasandirujuk',
            ),
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

