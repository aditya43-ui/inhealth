
<?php

$itemCssClass='table border';
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
     echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'colspan' => 4));
    
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
$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)) {
    $data = $model->searchPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
  
} else {
    $data = $model->searchPrint();
    $template = "{summary}\n{items}\n{pager}";
}
if ($caraPrint == 'PRINT' && $caraPrint != "GRAFIK"){
    
    
?>

 <table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
               if ($caraPrint != "PDF" && $caraPrint != "EXCEL" && $caraPrint != "GRAFIK") {
    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'colspan' => 10));
} ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                       
     
                <?php $this->widget($table,array(
                    'id'=>'tableLaporan',
                        'enableSorting'=>$sort,
                    'dataProvider'=>$data,
                        'template'=>$template,
                        'columns'=>array(
                //            array(
                //                'name'=>'<p style="margin: 0; text-align: center;">Tindakan</p>',
                //                'start'=>6, //indeks kolom 3
                //                'end'=>11, //indeks kolom 4
                //            ),
                //            array(
                //                'name'=>'<p style="margin: 0; text-align: center;">Karcis</p>',
                //                'start'=>13, //indeks kolom 3
                //                'end'=>16, //indeks kolom 4
                //            ),
                        ),
                        'itemsCssClass'=>$itemCssClass,
                    'columns'=>array(
                                array(
                                    'header' => 'No.',
                                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                                ),
                                        array(
                                    'header'=>'No. Pendaftaran',
                                    'type'=>'raw',
                                    'value'=>'$data->no_pendaftaran',
                                ),
                                array(
                                    'header' => 'No. Rekam Medik',
                                    'value' => '$data->no_rekam_medik'
                                ),
                                        array(
                                    'header'=>'Nama Pasien',
                                    'type'=>'raw',
                                    'value'=>'$data->namadepan." ".$data->nama_pasien',
                                ),
                                        array( 
                                    'header'=>'Alamat/<br>RT/RW ',
                                    'type'=>'raw',
                                    'value'=>'$data->Alamat',
                                ),
                            array(
                                    'header'=>'Umur ',
                                    'type'=>'raw',
                                    'value'=>'$data->umur',
                                ),
                                array(
                                    'header'=>'Golongan Darah',
                                    'type'=>'raw',
                                    'value'=>'$data->golongandarah',
                                ),
                                        array(
                                    'header'=>'Jenis Penjamin /<br>Penjamin ',
                                    'type'=>'raw',
                                    'value'=>'$data->Carabayar',
                                ),
                                                
                                        array(
                                    'header'=>'Transportasi/<br>Keadaan Masuk ',
                                    'type'=>'raw',
                                    'value'=>'$data->Transportasi',
                                ),
                //        'pasien_id',
                //        'jenisidentitas',
                //        'no_identitas_pasien',
                //        'namadepan',
                //        'nama_pasien',
                //        'nama_bin',
                            
                        
                //        'jeniskelamin',
                //        'tempat_lahir',
                //        'tanggal_lahir',
                //        'alamat_pasien',
                //        'rt',
                //        'rw',
                //        'agama',
                //        'golongandarah',
                //        'photopasien',
                //        'alamatemail',
                //        'statusrekammedis',
                //        'statusperkawinan',
                //        'no_rekam_medik',
                //        'tgl_rekam_medik',
                //        'propinsi_id',
                //        'propinsi_nama',
                //        'kabupaten_id',
                //        'kabupaten_nama',
                //        'kelurahan_id',
                //        'kelurahan_nama',
                //        'kecamatan_id',
                //        'kecamatan_nama',
                //        'pendaftaran_id',
                //        'no_pendaftaran',
                //        'tgl_pendaftaran',
                //        'no_urutantri',
                //        'transportasi',
                //        'keadaanmasuk',
                //        'statusperiksa',
                //        'statuspasien',
                //        'kunjungan',
                //        'alihstatus',
                //        'byphone',
                //        'kunjunganrumah',
                //        'statusmasuk',
                //        'umur',
                //        'no_asuransi',
                //        'namapemilik_asuransi',
                //        'nopokokperusahaan',
                //        'create_time',
                //        'create_loginpemakai_id',
                //        'create_ruangan',
                //        'carabayar_id',
                //        'carabayar_nama',
                //        'penjamin_id',
                //        'penjamin_nama',
                //        'shift_id',
                //        ////'ruangan_id',
                //        array(
                //                        'name'=>'ruangan_id',
                //                        'value'=>'$data->ruangan_id',
                //                        'filter'=>false,
                //                ),
                //        'ruangan_nama',
                //        'instalasi_id',
                //        'instalasi_nama',
                //        'jeniskasuspenyakit_id',
                //        'jeniskasuspenyakit_nama',
                //        'kelaspelayanan_id',
                //        'kelaspelayanan_nama',
                //        'pasienkecelakaan_id',
                //        'jeniskecelakaan_id',
                        'jeniskecelakaan_nama',
                            array(
                                'header' => 'Tanggal Kecelakaan',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->tglkecelakaan)'
                            ),        
                    'tempatkecelakaan',
                            array(
                                    'header'=>'Status Periksa',
                                    'type'=>'raw',
                                    'value'=>'$data->statusperiksa',
                                ),
                //        'keterangankecelakaan',
                                
                    ),
                        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                )); ?>

		</div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">

    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>

</div>   

<?php
}
if($caraPrint == 'PDF'){
    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'colspan' => 10));
    $this->widget($table,array(
        'id'=>'tableLaporan',
            'enableSorting'=>$sort,
        'dataProvider'=>$data,
            'template'=>$template,
            'columns'=>array(
    //            array(
    //                'name'=>'<p style="margin: 0; text-align: center;">Tindakan</p>',
    //                'start'=>6, //indeks kolom 3
    //                'end'=>11, //indeks kolom 4
    //            ),
    //            array(
    //                'name'=>'<p style="margin: 0; text-align: center;">Karcis</p>',
    //                'start'=>13, //indeks kolom 3
    //                'end'=>16, //indeks kolom 4
    //            ),
            ),
            'itemsCssClass'=>$itemCssClass,
        'columns'=>array(
                    array(
                        'header' => 'No.',
                        'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                    ),
                            array(
                        'header'=>'No. Pendaftaran',
                        'type'=>'raw',
                        'value'=>'$data->no_pendaftaran',
                    ),
                    array(
                        'header' => 'No. Rekam Medik',
                        'value' => '$data->no_rekam_medik'
                    ),
                            array(
                        'header'=>'Nama Pasien',
                        'type'=>'raw',
                        'value'=>'$data->namadepan." ".$data->nama_pasien',
                    ),
                            array( 
                        'header'=>'Alamat/<br>RT/RW ',
                        'type'=>'raw',
                        'value'=>'$data->Alamat',
                    ),
                array(
                        'header'=>'Umur ',
                        'type'=>'raw',
                        'value'=>'$data->umur',
                    ),
                    array(
                        'header'=>'Golongan Darah',
                        'type'=>'raw',
                        'value'=>'$data->golongandarah',
                    ),
                            array(
                        'header'=>'Jenis Penjamin /<br>Penjamin ',
                        'type'=>'raw',
                        'value'=>'$data->Carabayar',
                    ),
                                    
                            array(
                        'header'=>'Transportasi/<br>Keadaan Masuk ',
                        'type'=>'raw',
                        'value'=>'$data->Transportasi',
                    ),
    //        'pasien_id',
    //        'jenisidentitas',
    //        'no_identitas_pasien',
    //        'namadepan',
    //        'nama_pasien',
    //        'nama_bin',
                
            
    //        'jeniskelamin',
    //        'tempat_lahir',
    //        'tanggal_lahir',
    //        'alamat_pasien',
    //        'rt',
    //        'rw',
    //        'agama',
    //        'golongandarah',
    //        'photopasien',
    //        'alamatemail',
    //        'statusrekammedis',
    //        'statusperkawinan',
    //        'no_rekam_medik',
    //        'tgl_rekam_medik',
    //        'propinsi_id',
    //        'propinsi_nama',
    //        'kabupaten_id',
    //        'kabupaten_nama',
    //        'kelurahan_id',
    //        'kelurahan_nama',
    //        'kecamatan_id',
    //        'kecamatan_nama',
    //        'pendaftaran_id',
    //        'no_pendaftaran',
    //        'tgl_pendaftaran',
    //        'no_urutantri',
    //        'transportasi',
    //        'keadaanmasuk',
    //        'statusperiksa',
    //        'statuspasien',
    //        'kunjungan',
    //        'alihstatus',
    //        'byphone',
    //        'kunjunganrumah',
    //        'statusmasuk',
    //        'umur',
    //        'no_asuransi',
    //        'namapemilik_asuransi',
    //        'nopokokperusahaan',
    //        'create_time',
    //        'create_loginpemakai_id',
    //        'create_ruangan',
    //        'carabayar_id',
    //        'carabayar_nama',
    //        'penjamin_id',
    //        'penjamin_nama',
    //        'shift_id',
    //        ////'ruangan_id',
    //        array(
    //                        'name'=>'ruangan_id',
    //                        'value'=>'$data->ruangan_id',
    //                        'filter'=>false,
    //                ),
    //        'ruangan_nama',
    //        'instalasi_id',
    //        'instalasi_nama',
    //        'jeniskasuspenyakit_id',
    //        'jeniskasuspenyakit_nama',
    //        'kelaspelayanan_id',
    //        'kelaspelayanan_nama',
    //        'pasienkecelakaan_id',
    //        'jeniskecelakaan_id',
            'jeniskecelakaan_nama',
                array(
                    'header' => 'Tanggal Kecelakaan',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglkecelakaan)'
                ),        
        'tempatkecelakaan',
                array(
                        'header'=>'Status Periksa',
                        'type'=>'raw',
                        'value'=>'$data->statusperiksa',
                    ),
    //        'keterangankecelakaan',
                    
        ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));

}


?>



