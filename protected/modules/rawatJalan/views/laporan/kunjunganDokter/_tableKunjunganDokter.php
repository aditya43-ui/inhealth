<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
//    'filter'=>$model,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'mergeColumns' => array('instalasi_nama', 'ruangan_nama'),
    'columns'=>array(
        array(
          'name'=>'Instalasi / ."<br>".Ruangan',  
        ),
        'instalasi_nama',
        'ruangan_nama',
        'no_rekam_medik',
        'nama_pasien',
        'alamat_pasien',
        'jeniskelamin',
        'umur',
        'jeniskasuspenyakit_nama',
        'kelaspelayanan_nama',
        'tgl_pendaftaran',
        /*
        
        'tempat_lahir',
        'tanggal_lahir',
        
        'rt',
        'rw',
        'agama',
        'golongandarah',
        'photopasien',
        
        'statusrekammedis',
        'statusperkawinan',

        'tgl_rekam_medik',
        ////'pendaftaran_id',
        array(
                        'name'=>'pendaftaran_id',
                        'value'=>'$data->pendaftaran_id',
                        'filter'=>false,
                ),
        'no_pendaftaran',
        
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
        'shift_id',
        'ruangan_id',

        'instalasi_id',
        
        'jeniskasuspenyakit_id',
        
        'kelaspelayanan_id',
        
        'rujukan_id',
        'pasienpulang_id',
        'profilrs_id',
        */
        
        
        /*
        'ruangan_nama',
        'instalasi_id',
         * 'diagnosa_id',
        'instalasi_nama',*/
    ),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 
