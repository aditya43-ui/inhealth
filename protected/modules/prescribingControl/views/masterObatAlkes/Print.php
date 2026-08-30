
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
		////'obatalkesdetail_id',
		array(
			'header'=>'ID',
			'value'=>'$data->obatalkesdetail_id',
		),
		'obatalkes_id',
		array(
		'name'=>'indikasi',
		'type'=>'raw',
		'value'=>$model->indikasi,
		),
		array(
		'name'=>'kontraindikasi',
		'type'=>'raw',
		'value'=>$model->kontraindikasi,
		),
		array(
		'name'=>'komposisi',
		'type'=>'raw',
		'value'=>$model->komposisi,
		),
		array(
		'name'=>'efeksamping',
		'type'=>'raw',
		'value'=>$model->efeksamping,
		),
		/*
		'interaksiobat',
		'carapenyimpanan',
		'peringatan',
		*/
 
	),
)); 
?>