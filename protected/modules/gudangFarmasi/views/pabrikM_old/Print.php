
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
		////'pabrik_id',
		array(
			'header'=>'ID',
			'value'=>'$data->pabrik_id',
		),
		'pabrik_kode',
		'pabrik_nama',
		'pabrik_namalain',
		'pabrik_alamat',
		'pabrik_propinsi',
		array(
				'header'=>'Status',
				'type'=>'raw',
				'value'=>'(($data->pabrik_aktif) ? "Aktif" : "Tidak Aktif")',
			),
		/*
		'pabrik_kabupaten',
		'pabrik_aktif',
		*/
 
	),
)); 
?>