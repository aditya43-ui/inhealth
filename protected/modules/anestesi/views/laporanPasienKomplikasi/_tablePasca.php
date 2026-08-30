<?php

$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
  $row = '$row+1';
  $data = $model->searchLaporanPascaPrint();
  $template = "{items}";
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
} else{
  $data = $model->searchLaporanPasca();
}
?>
<?php $this->widget($table, array(
	'id'=>'pasca-grid',
	'dataProvider'=>$data,
	'itemsCssClass'=>'table table-striped table-condensed',
	'template'=>$template,
	'columns'=>array(
		array(
			'header'=>'Tanggal Pasca Anestesi',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglpascaanestesi)',
			'type'=>'raw',
		),
		array(
			'header'=>'No. Pasca Anestesi',
			'value'=>'$data->nopascaanestesi',
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
			'header'=>'Komplikasi',
			'value'=>'$data->komplikasipasca',
			'type'=>'raw',
		),
	),
)); ?>