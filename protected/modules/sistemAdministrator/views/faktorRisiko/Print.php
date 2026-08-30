<?php

$itemCssClass='table table-striped table-bordered table-condensed';
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
if($caraPrint!="PDF"){
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
}

$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)) {
	
	$template = "{items}";
	$sort = false;
	if ($caraPrint == "EXCEL"){
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
        }if ($caraPrint == "PDF"){
		$itemCssClass = 'table border';
        }        
}else if($caraPrint!='PDF'){
    echo $this->renderPartial('application.views.headerReport.headerLaporan',array('judulLaporan'=>$judulLaporan, 'colspan'=>10)); 
}else {
	$template = "{summary}\n{items}\n{pager}";
}
$data = $model->searchAdmin();
$data->pagination = false;

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
                    'header' => 'Diagnosa Keperawatan',
                    'name' => 'diagnosakep_nama',
                    'value' => 'isset($data->diagnosakep_nama) ? $data->diagnosakep_nama : " - "',
                ),
                array(
                    'header' => 'Jenis Faktor Risiko',
                    'name' => 'faktorrisiko_nama',
                    'value' => 'isset($data->faktorrisiko_nama) ? $data->faktorrisiko_nama : " - "',
                ),
                array(
                    'header' => 'Faktor Risiko',
                    'name' => 'jenisfaktorrisiko_nama',
                    'value' => 'isset($data->jenisfaktorrisiko_nama) ? $data->jenisfaktorrisiko_nama : " - "',
                ),
                array(
                    'header' => 'Status',
                    'value' => '($data->faktorrisiko_aktif == true ? \'Aktif\': \'Tidak Aktif\')',
                    
                ),
	),
));
?>