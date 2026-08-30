<?php
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
  $data = $model->searchPrint();
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
        'itemsCssClass'=>'table table-striped table-condensed',
    'columns'=>array(
        array(
            'header' => 'No',
            'value' => '$row+1'
        ),
         array(
            'header' => 'Tanggal Dirujuk',
            'value' => 'isset($data->tgldirujuk) ? MyFormatter::formatDateTimeForUser($data->tgldirujuk) : ""',
            ),
         array(
            'header' => 'No.Pendaftaran/ No.Rekam Medik',
            'value' => '$data->NoPenNoRM',
            ),
        'NamaBin',
        array(
            'header' => 'Alamat RT/RW',
            'value' => '$data->alamatRtRw',
            ),
        array(
            'header' => 'Jenis kelamin / Umur',
            'value' => '$data->jenisKelaminUmur',
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
            'header' => 'Dirujuk Ke Bagian',
            'value' => '$data->dirujukkebagian',
		),
        array(
            'header' => 'Alasan Dirujuk',
            'value' => '$data->alasandirujuk',
		),
    ),

)); ?> 

