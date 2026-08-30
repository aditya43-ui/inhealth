
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
		////'perhitunganem_id',
		array(
			'header'=>'ID',
			'value'=>'$data->perhitunganem_id',
		),
		'invperalatan_id',
		'res_fungsi_nama',
		'res_fungsi_nilai',
		'res_klinis_nama',
		'res_klinis_nilai',
		/*
		'res_pemeliharaan_nama',
		'res_pemeliharaan_nilai',
		'res_insiden_nama',
		'res_insiden_nilai',
		'nilai_em',
		'frekuensi_inspeksi',
		'perhitunganem_ket',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		*/
 
	),
)); 
?>