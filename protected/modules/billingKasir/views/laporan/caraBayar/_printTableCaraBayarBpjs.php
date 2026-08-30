<?php
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    $dataProvider = $model->searchPrintLaporanBpjs();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL"){
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$data['judulLaporan'].'-'.date("Y/m/d").'.xls"');
      header('Cache-Control: max-age=0');
    }

    echo $this->renderPartial('application.views.headerReport.headerLaporan',
        array(
            'judulLaporan'=>$data['judulLaporan'],
            'periode'=>$data['periode']
        )
    );
?>
<?php
    $this->widget($table,
        array(
            'id'=>'tbl_printbpjs',
            'dataProvider'=>$dataProvider,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'extraRowColumns' => array('penjamin_nama'),
            'columns'=>array(
              array(
                'header' => 'No.',
                'type'=>'raw',
                'value'=>'$row+1',
              ),
              array(
                'header'=>'Nama Penjamin',
                'type'=>'raw',
                'name'=>'penjamin_nama',
                'value'=>'$data->penjamin_nama',
              ),
              array(
                'header'=>'No. Pendaftaran',
                'type'=>'raw',
                'value'=>'$data->no_pendaftaran',
              ),
              array(
                'header'=>'Tanggal Pendaftaran',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
              ),
              array(
                'header'=>'Nama Lengkap',
                'type'=>'raw',
                'value'=>'$data->nama_pasien',
              ),
              array(
                'header'=>'Alamat',
                'type'=>'raw',
                'value'=>'$data->alamat_pasien',
              ),
              array(
                'header'=>'Status Masuk',
                'type'=>'raw',
                'value'=>'$data->statusmasuk',
              ),
              array(
                'header'=>'Instalasi',
                'type'=>'raw',
                'value'=>'$data->instalasi_nama',
              ),
              array(
                'header'=>'Ruangan',
                'type'=>'raw',
                'value'=>'$data->ruangan_nama',
              ),
              array(
                'header'=>'Nama Dokter',
                'type'=>'raw',
                'value'=>'$data->getNamaDokter()',
              ),
              array(
                'header'=>'Tanggal Pulang',
                'type'=>'raw',
                'value'=>'$data->getTglKeluar()',
              )
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )
    );
