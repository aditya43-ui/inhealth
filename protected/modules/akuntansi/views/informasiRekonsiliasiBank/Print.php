
<?php 
$table = 'ext.bootstrap.widgets.BootExcelGridView';
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

if($caraPrint=='EXCEL'){
	echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel',array('judulLaporan'=>$judulLaporan, 'colspan'=>7));  
} else {
	echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>5));  

}
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
		'htmlOptions'=>array('style'=>'text-align:center;'),
		),
		array(
			'header'=>'Tanggal Rekonsiliasi Bank',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->rekonsiliasibank_tgl)',
		),
		array(
			'header'=>'Bank',
			'type'=>'raw',
			'value'=>'$data->namabank',
		),
		array(
			'header'=>'Jenis Rekonsiliasi Bank',
			'type'=>'raw',
			'value'=>'$data->jenisrekonsiliasibank_nama',
		),
		array(
			'header'=>'Kode Rekening',
			'type'=>'raw',
			'value'=>'$data->kdrekening5',
		),
		array(
			'name'=>'Nama Rekening',
			'type'=>'raw',
			'value'=>'$data->getNamaRekening()',
		),
		array(
			'name'=>'Saldo Debit',
			'type'=>'raw',
			'value'=>'number_format($data->saldodebit,0,"",".")',
			'htmlOptions'=>array(
				'style'=>'text-align:right;',
			),
		),
		array(
			'name'=>'Saldo Kredit',
			'type'=>'raw',
			'value'=>'number_format($data->saldokredit,0,"",".")',
			'htmlOptions'=>array(
				'style'=>'text-align:right;',
			),
		),
	),
)); 
?>