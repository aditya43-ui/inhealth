<?php
$itemCssClass='table table-striped table-condensed';
if ($caraPrint == 'EXCEL') {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
	header('Cache-Control: max-age=0');
}if ($caraPrint != 'PDF') {
	//$itemCssClass='table table-striped table-condensed';
        echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan, 'colspan' => 5));
}

$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)) {
	$data = $model->printData();
	$template = "{items}";
	$sort = false;
	if ($caraPrint == "EXCEL"){
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
            }    
       if ($caraPrint == "PDF"){
		$itemCssClass='table border';
        }
                  
}else if($caraPrint!='PDF'){
    echo $this->renderPartial('application.views.headerReport.headerLaporan',array('judulLaporan'=>$judulLaporan, 'colspan'=>5)); 
} else {
	$data = $model->printData();
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
			'value' => '$row+1',
		),
		array(
			'header' => 'Nama Kondisi Klinis Terkait',
			'value' => '$data->faktorhub_daftar_nama',
		),
                array(
			'header' => 'Nama Lain Kondisi Klinis Terkait',
			'value' => '$data->faktorhub_daftar_namalain',
		),
		array(
			'header' => 'Status',
			'value' => '($data->faktorhub_daftar_aktif == true ? \'Aktif\': \'Tidak Aktif\')'
		),
	),
));
?>