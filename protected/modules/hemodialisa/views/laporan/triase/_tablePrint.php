<?php
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
  $data = $model->searchPrint();
  $template = "{items}";
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
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header' => 'No',
            'value' => '$row+1'
        ),
         array(
            'header' => 'No.pendaftaran / No.Rekam Medik',
            'value' => '$data->NoPenNoRM'
        ),
        'NamaBin',
        array(
            'header' => 'Alamat rt / rw',
            'value' => '$data->alamatRtRw'
        ),
        array(
            'header' => 'Jenis kelamin / Umur',
            'value' => '$data->jenisKelaminUmur'
        ),
        array(
            'header' => 'Cara bayar / Penjamin',
            'value' => '$data->caraBayarPenjamin'
        ),
        array(
            'header' => 'Cara keluar / Kondisi',
            'value' => '$data->caraKeluarKondisi'
        ),
        array(
            'header' => 'Nama Diagnosa',
            'value' => '$data->diagnosa_nama'
        ),
        array(
            'name'=>'kode_warnatriase',
            'type'=>'raw',
            'value'=>'$data->kode_warnatriase',
        )
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
        'triase_id',
        'triase_nama',
        'warna_triase',
        'kode_warnatriase',
        'keterangan_triase',
        'anamesa_id',
        'diagnosa_id',
        'diagnosa_kode',
        'diagnosa_nama',
<*/
    ),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 
