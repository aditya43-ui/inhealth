
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
		////'ttdelktronikpegawaisk_id',
		array(
			'header'=>'ID',
			'value'=>'$data->ttdelktronikpegawaisk_id',
		),
		'pegawai_id',
		'nomor_sk',
		'tglberlaku_awal',
		'tglberlaku_akhir',
		'file_surat',
		/*
		'path_file_surat',
		'create_time',
		'update_time',
		'create_loginpemakai',
		'update_loginpemakai',
		'create_petugaspengisi_id',
		'create_ruangan_id',
		*/
 
	),
)); 
?>