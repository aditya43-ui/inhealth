<?php
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$template = "{summary}\n{items}\n{pager}";
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
  $row = '$row+1';
  $data = $model->searchLaporan();
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
	'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'template'=>$template,
	'columns'=>array(
		array(
		    'header'=>'No.',
		    'value' => $row,
		),
		array(
			'name'=>'tglpemusnahan',
			'type'=>'raw',
			'value'=>'date("d/m/Y", strtotime($data->tglpemusnahan))',
		    ),
		array(
			'name'=>'nopemusnahan',
			'type'=>'raw',
			'value'=>'$data->nopemusnahan',
		),
		array(
			'name'=>'instalasi_nama',
			'type'=>'raw',
			'value'=>'$data->instalasi_nama',
		),
		array(
			'name'=>'ruangan_nama',
			'type'=>'raw',
			'value'=>'$data->ruangan_nama',
		),
		array(
			'name'=>'obatalkes_kode',
			'type'=>'raw',
			'value'=>'$data->obatalkes_kode',
		),
		array(
			'name'=>'obatalkes_nama',
			'type'=>'raw',
			'value'=>'$data->obatalkes_nama',
		),
		array(
			'name'=>'jmlbarang',
			'type'=>'raw',
			'value'=>'$data->jmlbarang',
		),
		array(
			'name'=>'pegawaimengetahui_id',
			'type'=>'raw',
			'value'=>'$data->PegawaimengetahuiLengkap',
		),
		array(
			'name'=>'pegawaimenyetujui_id',
			'type'=>'raw',
			'value'=>'$data->PegawaimenyetujuiLengkap',
		),
		array(
			'name'=>'keterangan',
			'type'=>'raw',
			'value'=>'$data->keterangan',
		),
	),
)); ?>