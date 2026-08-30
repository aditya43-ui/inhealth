<?php
$itemCssClass='table table-striped table-bordered table-condensed';
if($caraPrint=='EXCEL')
{
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
	header('Cache-Control: max-age=0');
}
// if($caraPrint!="PDF"){
	echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>5));
// }
$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)){
	$data = $model->searchPrint();
	$template = "{items}";
	$sort = false;
	if ($caraPrint == "EXCEL"){
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}if ($caraPrint == "PDF"){
		$itemCssClass = 'table border';
	}
} else{
	$data = $model->searchPrint();
	$template = "{summary}\n{items}\n{pager}";
}

$this->widget($table,array(
'id'=>'materiorientasi-m-grid',
'enableSorting'=>false,
'dataProvider'=>$data,
'template'=>$template,
'enableSorting'=>$sort,
'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
		array(
            'header' => 'No',
            'type'=>'raw',
            'value' => '$row+1',
        ),
        array(
            'name' => 'materiorientasi_nama',
            'type'=>'raw',
            'value' => '$data->materiorientasi_nama',
        ),
        array(
            'name' => 'materiorientasi_namalainnya',
            'type'=>'raw',
            'value' => '$data->materiorientasi_namalainnya',
        ),
        array(
            'name' => 'jenisorientasi',
            'type'=>'raw',
            'value' => '$data->jenisorientasi'
        ),
        array(
            'header' => 'Status',
            'type'=>'raw',
            'value' => '($data->materiorientasi_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
        ),
	),
    ));
?>
