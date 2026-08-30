
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

if($caraPrint!="PDF"){
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
}
$this->widget($table,array(
	'id'=>'coolboxdarah-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->search(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                    array(
                        'header'=>'No.',
                        'value' => '$row+1',
                    ),
                        'coolboxdarah_nama',
                        'coolbox_merk',
                        'coolbox_jenis',
                        'coolbox_ukuran',
                        'jml_icepack',
                        'jml_isikantong',
                        'jenis_kantong',
                        'standart_suhu',      
                    array(
                          'name'=>'coolbox_aktif',
                            'value'=>'($data->coolbox_aktif == 1) ? "Aktif" : "Tidak Aktif"',
                            'filter'=>array(1=>'Aktif',0=>'Tidak Aktif'),
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                    ),
	),
)); 
?>