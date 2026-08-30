
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
		////'bahanperawatan_id',
		array(
			'header'=>'ID',
			'value'=>'$data->jenislinen_id',
		),
                array(
                    'header'=>'No Jenis Linen',
                    'value' => '$data->jenislinen_no',
                ),
                array(
                    'header'=>'Jenis Linen',
                    'value' => '$data->jenislinen_nama',
                ),
                array(
                    'header'=>'Tanggal Diedarkan',
                    'value' => 'isset($data->tgldiedarkan)?MyFormatter::formatDateTimeForUser($data->tgldiedarkan):""',
                ),                
		array(
                    'header'=>'Warna Linen',
                    'value' => '$data->warnalinen',
                ),
		array(
                        'header' => 'Berwarna',
                        'value' => '($data->isberwarna)?"Ya":"Tidak"'
                    ),
 
	),
)); 
?>