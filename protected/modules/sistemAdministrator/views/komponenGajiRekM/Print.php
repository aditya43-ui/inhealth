
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
			'header'=>'No.',
			'value' => '($this->grid->dataProvider->pagination) ? 
					($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
					: ($row+1)',
			'type'=>'raw',
			'htmlOptions'=>array('style'=>'text-align:right;'),
		),
		array(
			'header'=>'Komponen Gaji',
			'value'=>'$data->komponengaji->komponengaji_nama',
		),
		array(
			'header'=>'Rekening',
			'value'=>'$data->rekening5->nmrekening5',
		),
		array(
			'header'=>'Jenis',
			'value'=>'($data->ispenggajian == 1)? "Penggajian" : (($data->ispembayarangaji == 1)?"Pembayaran Gaji":" - ")',
		),
		array(
			'header'=>'Debit / Kredit',
			'value'=>'($data->debitkredit == "D")?"Debit":"Kredit"',
		),	
	),
)); 
?>