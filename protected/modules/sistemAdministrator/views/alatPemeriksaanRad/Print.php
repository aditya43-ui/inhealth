
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
	'id'=>'sapemeriksaanmapalatrad-m-grid',
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
			'header'=>'ID',
			'name'=>'pemeriksaanalatrad_id',
			'value'=>'$data->pemeriksaanalatrad->pemeriksaanalatrad_id',
			'filter'=>false,
			),
		array(
			'header'=>'Nama Pemeriksaan',
			'name'=>'pemeriksaanalatrad_nama',
			'value'=>'$data->pemeriksaanalatrad->pemeriksaanalatrad_nama',
			'filter'=>false,
			),
		
		array(
			'header'=>'Daftar Tindakan',
			'name'=>'daftartindakan_nama',
			'value'=>'$data->pemeriksaanrad->daftartindakan->daftartindakan_nama',
			'filter'=>false,
			),
		array(
			'header'=>'Jenis Pemeriksaan',
			'name'=>'jenispemeriksaanrad_nama',
			'value'=>'$data->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama',
			'filter'=>false,
			),
		array(
			'header'=>'Nama Pemeriksaan Detail',
			'name'=>'pemeriksaanrad_nama',
			'value'=>'$data->pemeriksaanrad->pemeriksaanrad_nama',
			'filter'=>false,
			),
 
	),
)); 
?>