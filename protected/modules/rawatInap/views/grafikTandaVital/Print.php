
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
		////'grafiktandavital_id',
		array(
			'header'=>'ID',
			'value'=>'$data->grafiktandavital_id',
		),
		'pendaftaran_id',
		'pasienadmisi_id',
		'tgl_monitoring',
		'jam_monitoring',
		'pernapasan',
		/*
		'suhu',
		'nadi',
		'td_systolic',
		'td_dyastolic',
		'mosokomial',
		'berat_badan',
		'tinggi_badan',
		'bab',
		'cairan_masuk',
		'cairan_keluar',
		'petugaspengisi_id',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		*/
 
	),
)); 
?>