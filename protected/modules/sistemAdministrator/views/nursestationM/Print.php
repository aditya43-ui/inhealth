
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

echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>''));  

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'nursestation_id',
		array(
			'header'=>'ID',
			'value'=>'$data->nursestation_id',
		),
		array(
			'header'=>'Nama',
			'name'=>'nursestation_nama',
			'value' => '$data->nursestation_nama',
			'type'=>'raw',
			'filter'=>  CHtml::activeTextField($model,'nursestation_nama'),
		),
		array(
			'header'=>'Nama Lainnya',
			'value' => '$data->nursestation_namalain',
			'type'=>'raw',
		),
		array(
			'header'=>'Lokasi',
			'name'=>'nursestation_lokasi',
			'value' => '$data->nursestation_lokasi',
			'type'=>'raw',
			'filter'=>  CHtml::activeTextField($model,'nursestation_lokasi'),
		),
		array(
				'header'=>'Ruangan',
				'value' => '$data->getRuangan()',
				'type'=>'raw',
			),
		array(
			'header'=>'Telepon',
			'name'=>'nursestation_telp',
			'value' => '$data->nursestation_telp',
			'type'=>'raw',
			'filter'=>  CHtml::activeTextField($model,'nursestation_telp'),
		),
		array(
			'header'=>'Penanggung Jawab',
			'value' => 'isset($data->pegawai->nama_pegawai) ? $data->pegawai->nama_pegawai : ""',
			'type'=>'raw',
		),
		array(
			'header'=>'Aktif',
			'value' => '($data->nursestation_akitf==1) ? "AKTIF" : "TIDAK"',
			'type'=>'raw',
		),
 
	),
)); 
?>