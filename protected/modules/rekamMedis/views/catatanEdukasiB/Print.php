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
'id'=>'checklistprapost_op-m-grid',
'enableSorting'=>false,
'dataProvider'=>$data,
'template'=>$template,
'enableSorting'=>$sort,
'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
		////'alatmedis_id',
		 array(
        'header' => 'No',
        'value' => '$row+1',
      ),
			array(
					'header' => 'Nama Edukasi',
					'type' => 'raw',
					'value' => '$data->nama_edukasi',
			),
			array(
					'header' => 'Isi Edukasi',
					'type' => 'raw',
					'value' => '$data->isi_edukasi',
			),
			array(
					'header' => 'Status',
					'type' => 'raw',
					'value' => '($data->status == true ? \'Aktif\': \'Tidak Aktif\')'
			),
	),
    ));
?>
