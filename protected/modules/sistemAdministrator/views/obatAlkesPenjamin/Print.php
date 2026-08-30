
<?php 
$table = 'ext.bootstrap.widgets.BootGroupGridView';
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

echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>7));  

$this->widget($table,array(
	'id'=>'obatalkespenjamin-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'mergeColumns' => array('carabayar_id','penjamin_id'),
	'columns'=>array(
		array(
			'header' => 'No.',
			'value' => '($this->grid->dataProvider->pagination) ?
				($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
				: ($row+1)',
			'type' => 'raw',
			'htmlOptions' => array('style' => 'text-align:right;'),
		),
		array(
			'header' => 'Jenis Penjamin',
			'name' => 'carabayar_id',
			'type' => 'raw',
			'value' => '$data->carabayar->carabayar_nama',
		),
		array(
			'header' => 'Penjamin',
			'name' => 'penjamin_id',
			'type' => 'raw',
			'value' => '$data->penjamin->penjamin_nama',
		),
		array(
			'header' => 'Jenis Obat Alkes',
			'type' => 'raw',
			'value' => 'isset($data->jenisobatalkes->jenisobatalkes_nama)?$data->jenisobatalkes->jenisobatalkes_nama:"-"',
		),
		array(
			'header' => 'Margin (%)',
			'type' => 'raw',
			'value' => 'MyFormatter::formatNumberForPrint($data->persmargin,2)',
			'htmlOptions'=>array('style'=>'text-align: right')
		),
		array(
			'header' => 'Keringanan (%)',
			'type' => 'raw',
			'value' => 'MyFormatter::formatNumberForPrint($data->persdiskon,2)',
			'htmlOptions'=>array('style'=>'text-align: right')
		),
		array(
			'header' => 'Biaya Administrasi (Rp)',
			'type' => 'raw',
			'value' => 'MyFormatter::formatNumberForPrint($data->biayaadministrasi,2)',
			'htmlOptions'=>array('style'=>'text-align: right')
		)
	),
)); 
?>