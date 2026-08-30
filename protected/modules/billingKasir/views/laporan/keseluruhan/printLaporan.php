<?php
    if($caraPrint == 'EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $data['judulLaporan'] .'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    
    if($caraPrint == 'PRINT' || $caraPrint == 'PDF')
    {
        echo $this->renderPartial('application.views.headerReport.headerLaporan',
            array(
                'judulLaporan'=>$data['judulLaporan'],
                'periode'=>$data['periode']
            )
        );
        $table = 'ext.bootstrap.widgets.BootGroupGridView';
    }
    $sort = true;
    $dataProvider = $model->searchPrintLaporan();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
?>
<?php
    $this->widget($table,
        array(
            'id'=>'tableLaporanKeseluruhan',
            'dataProvider'=>$dataProvider,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'mergeColumns' => array('instalasi_nama', 'ruangan_nama'),
            'columns'=>array(
                array(
                  'header' => 'No.',
                  'type'=>'raw',
                  'value'=>'$row+1',
                ),       
                array(
                  'name'=>'tgl_pendaftaran',
                  'type'=>'raw',
                  'value'=>'date("d/m/Y H:i:s",strtotime($data->tgl_pendaftaran))',
                ),    
                'no_pendaftaran',
                'no_rekam_medik',
                'nama_pasien', 
                'statuspasien',
                'statusmasuk',
                'instalasi_nama',
                'ruangan_nama',
                'kelaspelayanan_nama',
                array(
                  'header'=>'Tanggal Pulang',
                  'type'=>'raw',
                  'value'=>'$data->getTglKeluar()',
                ),
                array(
                  'header'=>'Perujuk',
                  'type'=>'raw',
                  'value'=>'$data->getNamaPerujuk()',
                ),
                'jeniskelamin',
                array(
                  'header'=>'Diagnosa',
                  'type'=>'raw',
                  'value'=>'$data->getDiagnosa()',
                ),                
                array(
                  'header'=>'Nama Dokter',
                  'type'=>'raw',
                  'value'=>'$data->getNamaDokter()',
                ),
            ),
        )
    );
?>