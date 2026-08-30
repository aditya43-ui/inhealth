
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

echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>"Konfigurasi Backdate", 'colspan'=>''));  

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                'header' => 'Modul',
                'name' => 'modul_id',
                'value' => '$data->modul->modul_nama',
                'filter' => CHtml::activeDropDownList($model, 'modul_id', CHtml::listData(ModulK::model()->findAll('modul_aktif = true order by modul_nama asc'), 'modul_id', 'modul_nama'), array('empty' => '-- Pilih --')),
            ),
            'deskripsi_backdate',
            array(
                'name' => 'isbackdate',
                'filter' => false,
                'value' => '$data->isbackdate ? "Ya" : "Tidak"',
            ),
 
	),
)); 
?>