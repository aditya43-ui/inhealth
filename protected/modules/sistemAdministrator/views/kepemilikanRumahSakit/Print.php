
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
			'htmlOptions'=>array('style'=>'text-align:center;'),
		),
		array(
			'header'=>'<p style="margin: 0; text-align: center;">Kepemilikan Rumah Sakit</p>',
			'value'=>'$data->lookup_name',
			'htmlOptions'=>array('style'=>'text-align:left;'),
		),
		array(
			'header'=>'<p style="margin: 0; text-align: center;">Kepemilikan Rumah Sakit Lainnya</p>',
			'value'=>'$data->lookup_value',
			'htmlOptions'=>array('style'=>'text-align:left;'),
		),
		array(
			'header'=>'<p style="margin: 0; text-align: center;">Urutan</p>',
			'value'=>'$data->lookup_urutan',
			'htmlOptions'=>array('style'=>'text-align:center;'),
		),
                
		array(
			'header' => 'Status',
			'value'=>'($data->lookup_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
			'htmlOptions'=>array('style'=>'text-align:center;'),
		),
 
	),
)); 
?>