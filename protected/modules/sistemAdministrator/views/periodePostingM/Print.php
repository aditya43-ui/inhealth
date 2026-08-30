
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

if ($caraPrint=='EXCEL') {
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel',array('judulLaporan'=>$judulLaporan, 'colspan'=>6));      
} else {
    echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
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
			'htmlOptions'=>array('style'=>'text-align:right;'),
		),
		// array(
		// 	'header'=>'Konfig. Anggaran',
		// 	'value'=>'$data->konfiganggaran->deskripsiperiode',
		// ),
		array(
			'header'=>'Rekening Periode',
			'value'=>'$data->rekperiode->deskripsi',
		),
		'periodeposting_nama',
		array(
			'header'=>'Tgl. Awal Periode Posting',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglperiodeposting_awal)',
		),
		array(
			'header'=>'Tgl. Akhir Periode Posting',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglperiodeposting_akhir)',
		),		
		'deskripsiperiodeposting',
		array(
			'header' => 'Status',
			'value'=>'($data->periodeposting_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
			'htmlOptions'=>array('style'=>'text-align:center;'),
		),
		/*
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		'periodeposting_aktif',
		'rekperiode_id',
		*/
 
	),
)); 
?>