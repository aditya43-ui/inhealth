
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

if ($caraPrint=='EXCEL') {
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel',array('judulLaporan'=>$judulLaporan, 'colspan'=>3));      
} else {
    echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

}  

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'jadwalhari_id',
		'jadwalhari_nama',
		array(
			'header'=>'Senin',
			'value'=>'($data->jadwalhari_hari_senin == 1 ) ? "Ya" : " "',
		),
		array(
			'header'=>'Selasa',
			'value'=>'($data->jadwalhari_hari_selasa == 1 ) ? "Ya" : " "',
		),
		array(
			'header'=>'Rabu',
			'value'=>'($data->jadwalhari_hari_rabu == 1 ) ? "Ya" : " "',
		),
		array(
			'header'=>'Kamis',
			'value'=>'($data->jadwalhari_hari_kamis == 1 ) ? "Ya" : " "',
		),
		array(
			'header'=>'Jumat',
			'value'=>'($data->jadwalhari_hari_jumat == 1 ) ? "Ya" : " "',
		),
		array(
			'header'=>'Sabtu',
			'value'=>'($data->jadwalhari_hari_sabtu == 1 ) ? "Ya" : " "',
		),
		array(
			'header'=>'Minggu',
			'value'=>'($data->jadwalhari_hari_minggu == 1 ) ? "Ya" : " "',
		),
		array(
			'header'=>'Status',
			'value'=>'($data->jadwalhari_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
		),
 
	),
)); 
?>

<div class="">
</div>
<div class="footer">
    <?php   if (isset($caraPrint) && $caraPrint!="PDF" && $caraPrint!="EXCEL"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>