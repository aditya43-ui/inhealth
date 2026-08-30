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
			'header'=>'No.',
			'value' =>$row,
		),
		array(
			'header'=>'Tanggal',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglintraanestesi)',
			'type'=>'raw',
		),
		array(
			'header'=>'No. Intra Anestesi',
			'value'=>'$data->nointraanestesi',
			'type'=>'raw',
		),
		array(
			'header'=>'No. Rekam Medik',
			'value'=>'$data->no_rekam_medik',
			'type'=>'raw',
		),
		array(
			'header'=>'Nama Pasien',
			'value'=>'$data->nama_pasien',
			'type'=>'raw',
		),
		array(
			'header'=>'Ruangan',
			'value'=>'$data->ruangan_nama',
			'type'=>'raw',
		),
		array(
			'header'=>'Status Darurat',
			'value'=>'($data->isdarurat == true ? \'Ya\': \'Tidak\')',
			'type'=>'raw',
		),
	),
)); ?>