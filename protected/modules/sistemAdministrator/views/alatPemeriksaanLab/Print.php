
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
$itemCssClass='table border';
}
} else{
$data = $model->searchPrint();
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
		////'tipepaket_id',
		
		array(
				'header'=>'No.',
				'value' => '($row+1)',
				'type'=>'raw',
				'htmlOptions'=>array('style'=>'text-align:right;'),
			),
		array(
			'header'=>'Nama Alat Lab.',
			'name'=>'pemeriksaanlabalat_nama',
			'value'=>'$data->pemeriksaanlabalat->pemeriksaanlabalat_nama',
			
			),
		array(
			'header'=>'Kode Pemeriksaan',
			'name'=>'pemeriksaanlabalat_kode',
			'value'=>'$data->pemeriksaanlabalat->pemeriksaanlabalat_kode',
			
			),
		
		array(
			'header'=>'Kelompok Detail',
			'name'=>'kelompokdet',
			'value'=>'$data->nilairujukan->kelompokdet',
			
			),
		array(
			'header'=>'Pemeriksaan Detail',
			'name'=>'namapemeriksaandet',
			'value'=>'$data->nilairujukan->namapemeriksaandet',
			
			),
		array(
			'header'=>'Jenis Kelamin',
			'name'=>'nilairujukan_jeniskelamin',
			'value'=>'$data->nilairujukan->nilairujukan_jeniskelamin',
			
			),
		array(
			'header'=>'Nilai Rujukan',
			'name'=>'nilairujukan_nama',
			'value'=>'$data->nilairujukan->nilairujukan_nama',
			
			),
		array(
			'header'=>'Nilai Minimum',
			'name'=>'nilairujukan_min',
			'value'=>'$data->nilairujukan->nilairujukan_min',
			
			),
		array(
			'header'=>'Nilai Maksimum',
			'name'=>'nilairujukan_max',
			'value'=>'$data->nilairujukan->nilairujukan_max',
			
			),
		array(
			'header'=>'Satuan',
			'name'=>'satuan',
			'value'=>'$data->nilairujukan->nilairujukan_satuan',
			
			),

		
 
        ),
    )); 
?>
