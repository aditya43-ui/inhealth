
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
	'id'=>'sapemeriksaanalatrad-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'pemeriksaanalatrad_id',
		array(
				'header'=>'No.',
				'value' => '($row+1)',
				'type'=>'raw',
				'htmlOptions'=>array('style'=>'text-align:right;'),
			),
		array(
			'name'=>'pemeriksaanalatrad_id',
			'value'=>'$data->pemeriksaanalatrad_id',
			'filter'=>false,
			),
		array(
			'name'=>'alatmedis_id',
			'value'=>'$data->alatmedis->alatmedis_nama',
			'filter'=>CHtml::activeTextField($model,'alatmedis_nama'),
			),
		'pemeriksaanalatrad_kode',
		'pemeriksaanalatrad_nama',
		'pemeriksaanalatrad_namalain',
		'pemeriksaanalatrad_aetitle',
		/*
		'pemeriksaanalatrad_aktif',
		*/
		array(
				'header'=>'Status',
				'value' => '($data->pemeriksaanalatrad_aktif == true ? \'Aktif\': \'Tidak Aktif\')'
		), 
 
	),
)); 
?>