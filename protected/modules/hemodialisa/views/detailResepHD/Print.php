
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

if($caraPrint!="PDF"){
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
}
$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'resephd_id',
		array(
			'header'=>'No',
			'value'=>'$row+1',
		),
		array(
			'header'=>'Nama Paket',
			'value'=>'$data->resephd_nama',
		),
		array(
			'header'=>'Kode Obat/Alkes',
			'value'=>'$data->obatalkes_kode',
		),
		array(
			'header'=>'Nama Obat/Alkes',
			'value'=>'$data->obatalkes_nama',
		),
		array(
			'header'=>'Satuan Kecil',
			'value'=>'$data->satuankecil_nama',
		),
		array(
			'header'=>'Harga Satuan',
			'value'=>'$data->hargajual',
		),
//		'resephd_nama',
//		'resephd_desc',
//		'resephd_aktif',
//		array(
//				'name'=>'resephd_aktif',
//				'type'=>'raw',
//				'value'=>'(($data->resephd_aktif) ? "Aktif" : "Tidak Aktif")',
//			),
 
	),
)); 
?>