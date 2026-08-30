
<?php 
if ($caraPrint == 'GRAFIK' && $caraPrint != "PRINT"){
echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
echo $this->renderPartial('_grafik', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint), true); 
}

?>

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
                    'dataProvider'=>$data,
                //    'filter'=>$model,
                        'template'=>$template,
                        'itemsCssClass'=>$itemCssClass,
                    'columns'=>array(
                        array(
                            'header' => 'No.',
                            'value' => '$row+1'
                        ),
                        array(
                            'header' => 'No. Pendaftaran',
                            'value' => '$data->no_pendaftaran'
                        ),
                        array(
                            'header' => 'No. Rekam Medik',
                            'value' => '$data->no_rekam_medik'
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'value' => '$data->namadepan." ".$data->nama_pasien'
                        ),     
                        array(
                            'header' => 'Umur',
                            'value' => '$data->umur'
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
                            'header' => 'Triase',
                            'value' => '$data->triase_nama'
                        ),
                        array(
                            'header'=>'Kode Warna Triase',
                        //   'type'=>'raw',
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
        'dataProvider'=>$data,
    //    'filter'=>$model,
            'template'=>$template,
            'itemsCssClass'=>$itemCssClass,
        'columns'=>array(
            array(
                'header' => 'No.',
                'value' => '$row+1'
            ),
            array(
                'header' => 'No. Pendaftaran',
                'value' => '$data->no_pendaftaran'
            ),
            array(
                'header' => 'No. Rekam Medik',
                'value' => '$data->no_rekam_medik'
            ),
            array(
                'header' => 'Nama Pasien',
                'value' => '$data->namadepan." ".$data->nama_pasien'
            ),     
            array(
                'header' => 'Umur',
                'value' => '$data->umur'
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
                'header' => 'Triase',
                'value' => '$data->triase_nama'
            ),
            array(
                'header'=>'Kode Warna Triase',
            //   'type'=>'raw',
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
    ));
}


?>



