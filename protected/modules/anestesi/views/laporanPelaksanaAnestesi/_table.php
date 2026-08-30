<?php
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
  $row = '$row+1';
  $data = $model->searchLaporanPrint();
  $template = "{items}";
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
} else{
  $data = $model->searchLaporan();
}
?>
<?php $this->widget($table, array(
	'id'=>'laporan-grid',
	'dataProvider'=>$data,
	'itemsCssClass'=>'table table-striped table-condensed',
	'template'=>$template,
	'columns'=>array(
		array(
			'header'=>'Tanggal',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_laporan)',
			'type'=>'raw',
		),
		array(
			'header'=>'Ruangan',
			'value'=>'$data->ruangan_nama',
			'type'=>'raw',
		),
		array(
			'header'=>'Dokter Anestesi',
			'value'=>'$data->nama_dokter',
			'type'=>'raw',
		),
		array(
			'header'=>'Perawat Anestesi 1',
			'value'=>'$data->nama_perawat1',
			'type'=>'raw',
		),
		array(
			'header'=>'Perawat Anestesi 2',
			'value'=>'$data->nama_perawat2',
			'type'=>'raw',
		),
		array(
			'header'=>'Jumlah Pasien',
			'value'=>'$data->totalpasien',
			'type'=>'raw',
		),
	),
)); ?>