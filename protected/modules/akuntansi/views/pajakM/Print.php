
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
	'id'=>'printpajak-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
                        'header'=>'Nama Pajak',
                        'name'=>'pajak_nama',
                        'value'=>'$data->pajak_nama',
                ),
            array(
                        'header'=>'Nama Lain Pajak',
                        'name'=>'pajak_namalain',
                        'value'=>'$data->pajak_namalain',
                ),
            array(
                        'header'=>'Nama Rekening',
                        'name'=>'rekening5_nama',
                        'value'=>'(isset($data->rekening5)?$data->rekening5->nmrekening5:"")',
                ),
            array(
                        'header'=>'Keterangan',
                        'name'=>'keterangan',
                        'value'=>'$data->keterangan',
                ),
        array(
                        'header'=>'Status',
                        'value' => '($data->pajak_aktif == true ? \'Aktif\': \'Tidak Aktif\')'
        ),   
 
	),
)); 
?>