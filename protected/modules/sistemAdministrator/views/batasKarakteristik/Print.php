<?php
$itemCssClass='table table-striped table-bordered table-condensed';
if ($caraPrint == 'EXCEL') {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
	header('Cache-Control: max-age=0');
}
if($caraPrint!="PDF"){
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>5));      
}

$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)) {
	$data = $model->searchPrint();
	$template = "{items}";
	$sort = false;
	if ($caraPrint == "EXCEL"){
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
        } if ($caraPrint == "PDF"){
		$itemCssClass = 'table border';
//        }else if($caraPrint!='PDF'){
//            echo $this->renderPartial('application.views.headerReport.headerLaporan',array('judulLaporan'=>$judulLaporan, 'colspan'=>10)); 
        }
        
}
else {
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
			'value' => '$row+1',
		),
		array(
			'header' => 'Diagnosa Keperawatan',
			'value' => 'isset($data->diagnosakep_nama) ? $data->diagnosakep_nama : " - "',
		),
		array(
			'header' => 'Jenis Penyebab',
			'value' => 'isset($data->bataskarakteristik->bataskarakteristik_nama) ? $data->bataskarakteristik->bataskarakteristik_nama : " - "',
		),
		array(
			'header' => 'Faktor Penyebab',
			'value' =>  function ($data){
                                            if(!empty($data->faktorpenyebab_daftar_id)){
                                                $cekFaktor = FaktorpenyebabDaftarM::model()->findByPk($data->faktorpenyebab_daftar_id);
                                                echo !empty($cekFaktor) ? $cekFaktor->faktorpenyebab_daftar_nama : '-';
                                            }else{
                                                echo '-';
                                            }
                                    },
		),
		array(
			'header' => 'Status',
			'value' => '($data->bataskarakteristikdet_aktif == true ? \'Aktif\': \'Tidak Aktif\')'
		),
	),
));
?>