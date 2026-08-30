
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
                    'header' => 'ID',
                    'value' => '$data->bahanlinen_id',
                    ),
                array(
                    'header' => 'Bahan Linen',
                    'value' => '$data->bahanlinen_nama'
                ),
                array(
                    'header' => 'Nama Lain',
                    'value' => '$data->bahanlinen_namalain'
                ),
                array(
                    'header' => 'Suhu Rekomendasi',
                    'value' => '$data->suhurekomendasi'
                ),
                array(
                    'header' => 'Status',
                    'value' => '($data->bahanlinen_aktif)?"Aktif":"Tidak Aktif"'
                ),
 
	),
)); 
?>