<?php
$itemCssClass='table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{items}";
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
            'value' => '$row+1'
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
         array(
            'header' => 'Rumah Sakit Rujukan',
            'value' => '$data->rumahsakitrujukan',
            ), 
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
      
    ),

)); ?> 

