<?php
$itemCssClass='table table-striped table-bordered table-condensed';
if($caraPrint=='EXCEL')
{
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
	header('Cache-Control: max-age=0');
}
if($caraPrint!="PDF"){
	echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));
}
$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)){
	$data = $model->searchPrint();
	$template = "{items}";
	$sort = false;
	if ($caraPrint == "EXCEL"){
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}if ($caraPrint == "PDF"){
		$itemCssClass = 'table border';
	}
} else{
	$data = $model->searchPrint();
	$template = "{summary}\n{items}\n{pager}";
}

$this->widget($table,array(
'id'=>'jenisgerakprint-grid',
'enableSorting'=>false,
'dataProvider'=>$data,
'template'=>$template,
'enableSorting'=>$sort,
'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
		 array(
	      'header' => 'No',
	      'value' => '$row+1',
	    ),
			array(
					'header'=>'Pemeriksaan Fisik Gerak Dasar',
					'type'=>'raw',
					'value'=>'(isset($data->periksafungsigerakdasar)?$data->periksafungsigerakdasar->periksafungsigerakdasar_nama:"")',
			),
			array(
					'header'=>'Nama Pemeriksaan',
					'type'=>'raw',
					'value'=>'$data->fungsigerakdasarsinistra_nama',
			),
			array(
					'header'=>'Nama Lainnya',
					'type'=>'raw',
					'value'=>'$data->fungsigerakdasarsinistra_namalainnya',
			),
			array(
					'header'=>'Urutan',
					'type'=>'raw',
					'value'=>'$data->fungsigerakdasarsinistra_urutan',
			),
			array(
					'header'=>'<center>Status</center>',
					'type'=>'raw',
					'value'=>'($data->fungsigerakdasarsinistra_aktif == 1) ? "Aktif" : "Tidak Aktif"',
					'htmlOptions'=>array('style'=>'text-align:center;'),
			),
    ),
));
?>
