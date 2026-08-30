<?php
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
$itemCss = 'table table-bordered datatable';
$table = 'ext.bootstrap.widgets.BootGroupGridView';
$sort = true;
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }

    $itemCss = 'table border';
} else {
    $data = $model->searchTableLaporan();
    $template = "{summary}\n{items}\n{pager}";
}
?>
<?php if (!isset($caraPrint)) { ?>
<?php } ?>
<?php $this->widget($table, array(
    'id' => 'PPInfoKunjungan-v',
    'dataProvider' => $data,
    //    'filter'=>$model,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => $itemCss,
    'mergeColumns' => array('ruangan_nama'),
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => $row
        ),
        'ruangan_nama',
        array(
            'header' => 'Spesialis',
            'value' => '$data->jeniskasuspenyakit_nama'
        ),
        'no_rekam_medik',
        //        'jenisidentitas',
        //        'no_identitas_pasien',
        //        'namadepan',      
        array(
            'header' => 'Nama Pasien',
            'value' => '$data->namadepan." ".$data->nama_pasien'
        ),
        'no_pendaftaran',
        'umur',
        // 'jeniskelamin',
        'alamat_pasien',
        array(
            'header' => 'Kelas Pelayanan',
            'value' => '$data->kelaspelayanan_nama',
        ),
        //        'kelaspelayanan_nama',
        array(
            'header' => 'Nama Karcis',
            'value' => '$data->karcis_nama',
        ),
        //        'daftartindakan_id',
        //        'harga_tariftindakan',
        array(
            'header' => 'Harga Nominal Tarif (Rp)',
            'value' => 'number_format($data->harga_tariftindakan,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header'=>'Petugas Loket',
            'type'=>'raw',
            'value'=>function($data){
                echo isset($data->petugas_loket) ? $data->petugas_loket :'-';
                
            },
        ),
        //        'nama_bin',
        /*
        
        'tempat_lahir',
        'tanggal_lahir',
        
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
        'propinsi_id',
        'propinsi_nama',
        'kabupaten_id',
        'kabupaten_nama',
        'kelurahan_id',
        'kelurahan_nama',
        'kecamatan_id',
        'kecamatan_nama',
        ////'pendaftaran_id',
        array(
                        'name'=>'pendaftaran_id',
                        'value'=>'$data->pendaftaran_id',
                        'filter'=>false,
                ),
        
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
        
        'no_asuransi',
        'namapemilik_asuransi',
        'nopokokperusahaan',
        'create_time',
        'create_loginpemakai_id',
        'create_ruangan',
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
        'kelaspelayanan_id',
        
        'rujukan_id',
        'pasienpulang_id',
        'profilrs_id',
        'karcis_id',

         * */

    ),
    //        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 

<?php //$this->widget('ext.bootstrap.widgets.BootGridView',array(
//	'id'=>'PPInfoKunjungan-v',
//	'dataProvider'=>$data,
//        'template'=>"{summary}\n{items}\n{pager}",
//        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//	'columns'=>array(
//            'no_rekam_medik',    
//            'NamaNamaBIN',
//            'jeniskasuspenyakit_nama',
//             array(
//               'name'=>'no_pendaftaran',
//               'type'=>'raw',
//               'value'=>'$data->no_pendaftaran',
//               'htmlOptions'=>array('style'=>'text-align: center; width:120px')
//            ),
//            'alamat_pasien',
//            'nama_pegawai',
//            array(
//               'name'=>'CaraBayar/Penjamin',
//               'type'=>'raw',
//               'value'=>'$data->CaraBayarPenjamin',
//               'htmlOptions'=>array('style'=>'text-align: center')
//            ),            
//            array(
//               'name'=>'ruangan_nama',
//               'type'=>'raw',
//               'value'=>'$data->ruangan_nama',
//               'htmlOptions'=>array('style'=>'text-align: center')
//            ),
//            array(
//               'name'=>'statusperiksa',
//               'type'=>'raw',
//               'value'=>'$data->statusperiksa',
//               'htmlOptions'=>array('style'=>'text-align: center')
//            ),
//	),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
//)); 
?>