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
			'header'=>'No. Rencana',
			'value'=>'$data->no_rencana',
			'type'=>'raw',
		),
		array(
			'header'=>'Tgl. Rencana',
			'value'=>'MyFormatter::formatDateTimeForUser($data->rencanaaskep_tgl)',
			'type'=>'raw',
		),
		array(
			'header'=>'No. Pendaftaran',
			'value'=>'$data->no_pendaftaran',
			'type'=>'raw',
		),
		array(
			'header'=>'Nama Pasien',
			'value'=>'$data->nama_pasien',
			'type'=>'raw',
		),
		array(
			'header'=>'Jenis Kelamin',
			'value'=>'$data->jeniskelamin',
			'type'=>'raw',
		),
		array(
			'header'=>'Nama Perawat',
			'value'=>'$data->nama_pegawai',
			'type'=>'raw',
		),
		array(
			'header'=>'Ruangan',
			'value'=>'$data->ruangan_nama',
			'type'=>'raw',
		),
		array(
			'header'=>'Kelas Pelayanan',
			'value'=>'$data->kelaspelayanan_nama',
			'type'=>'raw',
		),
		array(
			'header'=>'No. Kamar / No. Bed',
			'value'=>'$data->kamarruangan_nokamar . " / ".$data->kamarruangan_nobed',
			'type'=>'raw',
		),
	),
)); ?>