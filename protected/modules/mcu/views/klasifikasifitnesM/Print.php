
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
		
		array(
			'name'=>'klasifikasifitnes_id',
			'htmlOptions'=>array('style'=>'text-align:center;','width'=>'20px;'),
		),
		'age_elev',
		'lama_menit',
		'workload_kph',
		'estimasirate',
		'max_intake',
		'mets',
		'umur_min',
		'umur_maks',
		'klasifikasifitnes',
		'functional_class',
		'walking_kmhr',
		'jogging_kmhr',
		'bicycling_kmhr',
		'other_sports',
		array(
			'header'=>'Status Aktif',
			'value'=>'(($data->klasifikasifitnes_aktif) ? "Aktif" : "Tidak Aktif")',
			'htmlOptions'=>array('style'=>'text-align:center;','width'=>'20px;'),
		),
 
	),
)); 
?>