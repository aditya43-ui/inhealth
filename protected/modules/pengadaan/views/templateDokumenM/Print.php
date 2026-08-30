
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

echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>'12'));  

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrintTemplatePengadaan(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
                            'header' => 'Jenis Dokumen',
                            'type' => 'raw',
                            'value' => 'isset($data->jenissurat->jenissurat_nama) ? $data->jenissurat->jenissurat_nama : ""',
                        ),
                        'konfigtemplatesurat_nama',
                        'nama_lain',
                        array(
                            'header' => 'Isi',
                            'type' => 'raw',
                            'value' => '$data->konfigtemplatesurat_isi',
                        ),
                        array(
                            'header' => 'Keterangan',
                            'type' => 'raw',
                            'value' => '$data->keterangan',
                        ),
                        'urutan',
                        array(
                            'header' => 'Status',
                            'type' => 'raw',
                            'value' => '($data->konfigtemplatesurat_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                        ),
 
	),
)); 
?>