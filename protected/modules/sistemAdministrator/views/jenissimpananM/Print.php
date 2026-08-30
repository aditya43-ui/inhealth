
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
		////'jenissimpanan_id',
		array(
			'header'=>'ID',
			'value'=>'$data->jenissimpanan_id',
		),
		'kodesimpanan',
		'jenissimpanan',
		'jenissimpanan_namalain',
		'jangkapenarikanbln',
		'persenjasathn',
		/*
		'persenpajakthn',
		'jns_create_time',
		'jns_update_time',
		'jns_create_login',
		'jns_update_login',
		'jenissimpanan_aktif',
		'jenissimpanan_singkatan',
		*/
 
	),
)); 
?>