<?php
$itemCssClass='table table-striped table-bordered table-condensed';
if($caraPrint=='EXCEL')
{
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
header('Cache-Control: max-age=0');
}
if($caraPrint!="PDF"){
echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));
}
$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)){
$data = $model->searchPrintBank();
$template = "{items}";
$sort = false;
if ($caraPrint == "EXCEL"){
$table = 'ext.bootstrap.widgets.BootExcelGridView';
}if ($caraPrint == "PDF"){
$itemCssClass='table border';
}
} else{
$data = $model->searchPrintBank();
$template = "{summary}\n{items}\n{pager}";
}

$this->widget($table,array(
'id'=>'sajenis-kelas-m-grid',
'enableSorting'=>false,
'dataProvider'=>$data,
'template'=>$template,
'enableSorting'=>$sort,
'itemsCssClass'=>$itemCssClass,
	 'columns'=>array(
        ////'lookup_id',
       array(
                    'header' => 'No.',
                    'value' => '$row+1',
                    ),
        'lookup_type',
        'lookup_name',
        'lookup_value',
		'lookup_kode',
		'lookup_urutan',
		array(
			'header' => 'Status',
			'value'=>'($data->lookup_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
			'htmlOptions'=>array('style'=>'text-align:center;'),
		),
/*
        'lookup_aktif',
        */
 
        ),
    )); 
?>