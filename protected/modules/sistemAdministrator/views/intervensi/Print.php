<?php
$itemCssClass = 'table table-striped table-condensed';
if ($caraPrint == 'EXCEL') {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
	header('Cache-Control: max-age=0');
}
if ($caraPrint != 'PDF') {
	//$itemCssClass = 'table table-striped table-condensed';
        echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan, 'colspan' => 10));
}

$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)) {
	$data = $model->searchPrint();
	$template = "{items}";
	$sort = false;
	if ($caraPrint == "EXCEL"){
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
        if ($caraPrint == "PDF"){
		$itemCssClass = 'table border';
        }
                  
}else if($caraPrint!='PDF'){
    echo $this->renderPartial('application.views.headerReport.headerLaporan',array('judulLaporan'=>$judulLaporan, 'colspan'=>10)); 
}else {
	$data = $model->searchPrint();
	$template = "{summary}\n{items}\n{pager}";
}

$this->widget($table, array(
	'id' => 'sajenis-kelas-m-grid',
	'enableSorting' => $sort,
	'dataProvider' => $data,
	'template' => $template,
	'itemsCssClass' => $itemCssClass,
	'columns' => array(
		array(
			'header' => 'No.',
			'value' => '($this->grid->dataProvider->pagination) ? 
                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1): ($row+1)',
		),
		array(
			'header' => 'Diagnosa Keperawatan',
			'value' => 'isset($data->diagnosakep_nama) ? $data->diagnosakep_nama : " - "',
		),
		array(
			'header' => 'Nama Intervensi',
			'value' => 'isset($data->intervensi->intervensi_nama) ? $data->intervensi->intervensi_nama : " - "',
		),
		array(
			'header' => 'Indikator',
			'value' => 'isset($data->intervensidet_indikator) ? $data->intervensidet_indikator : " - "',
		),
		array(
			'header' => 'Status',
			'value' => '($data->intervensidet_aktif == true ? \'Aktif\': \'Tidak Aktif\')'
		),
	),
));
?>