
<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
	$template = "{items}";
	if($caraPrint=='EXCEL'){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');   
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
}

echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>''));  

$this->widget($table,array(
	'id'=>'rekening-anggaran-v-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
		'header' => 'No.',
		'type'=>'raw',
		'value'=>'$row+1',
		'htmlOptions'=>array('style'=>'width:20px')
		),
		array(
			'header'=>'Kode Program',
			'name'=>'programkerja_kode',
			'type'=>'raw',
			'value'=>'$data->programkerja_kode',
		),
		array(
			'header'=>'Kode Sub Program',
			'name'=>'subprogramkerja_kode',
			'type'=>'raw',
			'value'=>'($data->subprogramkerja_kode == null ? "-" : $data->subprogramkerja_kode)',
		),
		array(
			'header'=>'Kode Kegiatan',
			'name'=>'kegiatanprogram_kode',
			'type'=>'raw',
			'value'=>'$data->kegiatanprogram_kode',
		),
		array(
			'header'=>'Kode Sub Kegiatan',
			'name'=>'subkegiatanprogram_kode',
			'type'=>'raw',
			'value'=>'($data->subkegiatanprogram_kode == null ? "-" : $data->subkegiatanprogram_kode)',
		),
		array(
			'header'=>'Program',
			'name'=>'programkerja_nama',
			'type'=>'raw',
			'value'=>'isset($data->programkerja_nama) ? $data->programkerja_nama : "-"',
		),
		array(
			'header'=>'Sub Program',
			'name'=>'subprogramkerja_nama',
			'type'=>'raw',
			'value'=>'isset($data->subprogramkerja_nama) ? $data->subprogramkerja_nama : "-"',
		),
		array(
			'header'=>'Kegiatan',
			'name'=>'kegiatanprogram_nama',
			'type'=>'raw',
			'value'=>'isset($data->kegiatanprogram_nama) ? $data->kegiatanprogram_nama : "-"',
		),
		array(
			'header'=>'Sub Kegiatan',
			'name'=>'subkegiatanprogram_nama',
			'type'=>'raw',
			'value'=>'isset($data->subkegiatanprogram_nama) ? $data->subkegiatanprogram_nama : "-"',
		),
		array(
			'header'=>'Rekening Debit Akuntansi',
			'name'=>'rekening5debit_nama',
			'type'=>'raw',
			'value'=>'($data->rekening5debit_nama == null ? "-" : $data->rekening5debit_nama)',
		),
		array(
			'header'=>'Rekening Kredit Akuntansi',
			'name'=>'rekening5kredit_nama',
			'type'=>'raw',
			'value'=>'($data->rekening5kredit_nama == null ? "-" : $data->rekening5kredit_nama)',
		),
		array(
			'header'=>'Keterangan',
			'name'=>'subkegiatanprogram_ket',
			'type'=>'raw',
			'value'=>'isset($data->subkegiatanprogram_ket) ?  $data->subkegiatanprogram_ket : "-"',
		),
		array(
			'header'=>'Status',
			'name'=>'subkegiatanprogram_aktif',
			'type'=>'raw',
			'value'=>'($data->subkegiatanprogram_aktif == true ? "Aktif" : "Tidak Aktif")',
		),
	),
)); 
?>