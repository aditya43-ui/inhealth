
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
		////'resephd_id',
		array(
			'header'=>'No',
			'value'=>'$row+1',
		),
		'shift_hd_nama',
		'shift_hd_namalainnya',
		'shift_hd_jamawal',
            'shift_hd_jamakhir',
            'shift_hd_urutan',
		array(
				'name'=>'shift_hd_aktif',
				'type'=>'raw',
				'value'=>'(($data->shift_hd_aktif) ? "Aktif" : "Tidak Aktif")',
			),
 
	),
)); 
?>