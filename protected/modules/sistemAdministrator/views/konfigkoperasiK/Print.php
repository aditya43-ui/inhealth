
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
	'id'=>'sajenis-kelas-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'konfigkoperasi_id',
		array(
			'header'=>'ID',
			'value'=>'$data->konfigkoperasi_id',
		),
		'persjasasimpanan',
		'persjasapinjaman',
		'persdanapengurus',
		'persdanakaryawan',
		'persdanapendidikan',
		/*
		'persdanasosial',
		'persdanacadangan',
		'persbiayaprovisasi',
		'persjasadeposito',
		'pimpinankoperasi_id',
		'penguruskoperasi_id',
		'bendaharakoperasi_id',
		'bendaharars_id',
		'status_aktif',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		*/
 
	),
)); 
?>