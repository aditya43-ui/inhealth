
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
	echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel',array('judulLaporan'=>$judulLaporan, 'colspan'=>6));  
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
		////'jenisbarangrek_id',
		array(
			'header'=>'No.',
			'value' => '($this->grid->dataProvider->pagination) ? 
					($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
					: ($row+1)',
			'type'=>'raw',
			'htmlOptions'=>array('style'=>'text-align:center;'),
		),
		'kelbahanmakanan',
		array(
			'header'=>'Rekening 5',
			'value'=>'$data->rekening5->nmrekening5',
		),
		'debitkredit',
                array(
			'header'=>'Penerimaan',
			'value'=>'($data->ispenerimaan==0)?"Tidak":"Ya"',
		),
            array(
			'header'=>'Pemakaian',
			'value'=>'($data->ispemakaian==0)?"Tidak":"Ya"',
		),
		array(
			'header'=>'Retur Penerimaan',
			'value'=>'($data->isreturpenerimaan==0)?"Tidak":"Ya"',
		),
		array(
			'header'=>'Stok Opname Awal',
			'value'=>'($data->istokopname==0)?"Tidak":"Ya"',
		),
		array(
			'header'=>'Stok Opname Penyesuaian Bertambah',
			'value'=>'($data->istokopnamebertambah==0)?"Tidak":"Ya"',
		),
		array(
			'header'=>'Stok Opname Penyesuaian Berkurang',
			'value'=>'($data->istokopnameberkurang==0)?"Tidak":"Ya"',
		),
 
	),
)); 
?>