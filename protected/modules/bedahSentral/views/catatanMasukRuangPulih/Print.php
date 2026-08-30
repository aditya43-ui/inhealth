
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
		////'pasienruangpulih_id',
		array(
			'header'=>'ID',
			'value'=>'$data->pasienruangpulih_id',
		),
		'pasien_id',
		'pendaftaran_id',
		'pasienadmisi_id',
		'asesmentnyeri_id',
		'masukkamar_id',
		/*
		'tindaklanjutpasien_masukkamar_id',
		'masukruanganpulih_tanggal',
		'masukruanganpulih_jam',
		'dokteranastesi_id',
		'petugas_saatmasukruangpulih_id',
		'totalskor_aldrettemasukrpulih',
		'isdisposableinfuspump',
		'disposableinfuspump_ket',
		'ismelaluicathepidural',
		'melaluicathepidural_ket',
		'istatalaksananyerilainnya',
		'istatalaksananyerilainnya_ket',
		'keluarruanganpulih_tanggal',
		'keluarruanganpulih_jam',
		'petugas_saatkeluarruangpulih_id',
		'score_skalanyeri',
		'keteranganskala_nyeri',
		'totalskor_aldrettekeluarrpulih',
		'instruksi_bilanyeri',
		'intruksi_mualmuntah',
		'instruksi_infus',
		'instruksi_makanminum',
		'instruksi_obat',
		'tindaklanjutpasien',
		'tindaklanjutpasien_ruanganrawat_id',
		'tindaklanjutpasien_kamarruangan_id',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		*/
 
	),
)); 
?>