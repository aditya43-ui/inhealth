<?php
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$template="{summary}\n{items}\n{pager}";
$sort = true;
$data = $model->searchTables();  
if (isset($caraPrint)){
  $sort = false;
  $template = "{items}";
  $data = $model->searchPrint();
  if ($caraPrint == 'EXCEL')
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
  $data = $model->searchTables();
?>
<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'mergeHeaders'=>array(
//            array(
//                'name'=>'<center>Tindakan</center>',
//                'start'=>6, //indeks kolom 3
//                'end'=>11, //indeks kolom 4
//            ),
//            array(
//                'name'=>'<center>Karcis</center>',
//                'start'=>13, //indeks kolom 3
//                'end'=>16, //indeks kolom 4
//            ),
        ),
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
                array(
                    'header' => 'No',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                ),
// array(
//                        'name'=>'pendaftaran_id',
//                        'value'=>'$data->pendaftaran_id',
//                        'filter'=>false,
//                ),s
            array(
                    'header'=>'Tanggal Pendaftaran/<br/>Tanggal Meninggal',
                    'type'=>'raw',
                    'value'=>'$data->Tanggal',
                ),
            array(
                    'header'=>'No. Pendaftaran/<br/>No. Rekam Medis',
                    'type'=>'raw',
                    'value'=>'$data->RM',
                ),
            array(
                    'header'=>'Nama Pasien /<br/>Bin/Binti ',
                    'type'=>'raw',
                    'value'=>'$data->Nama',
                ),
            array( 
                    'header'=>'Alamat /<br/>RT/RW ',
                    'type'=>'raw',
                    'value'=>'$data->Alamat',
                ),
            array(
                    'header'=>'Jenis Kelamin /<br/>Umur ',
                    'type'=>'raw',
                    'value'=>'$data->Umur',
                ),
            array(
                    'header'=>'Agama /<br/>Golongan Umur ',
                    'type'=>'raw',
                    'value'=>'$data->Agama',
                ),
             'kondisipulang',
            array(
                    'header'=>'Jenis Penjamin /<br/>Penjamin ',
                    'type'=>'raw',
                    'value'=>'$data->Carabayar',
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
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>