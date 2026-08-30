
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
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
}
$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'jenisdialisat_id',
		array(
			'header'=>'No',
			'value'=>'$row+1',
		),
		'jenisdialisat_nama',
		'jenisdialisat_namalain',
//		'jenisdialisat_deskripsi',
                array(
			'header'=>'Deskripsi',
			'value'=>'$data->jenisdialisat_deskripsi',
		),
		array(
			'header'=>'Aktif',
			'value'=>'($data->jenisdialisat_aktif==1)? "YA" : "TIDAK"',
			'type'=>'raw',
		),
 
	),
)); 
?>