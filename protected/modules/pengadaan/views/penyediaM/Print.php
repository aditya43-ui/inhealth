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
	'id'=>'penyedia-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'No.',
                    'value' => '($this->grid->dataProvider->pagination) ? 
                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                    : ($row+1)',
                    'type'=>'raw',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
		'penyedia_kode',
		'penyedia_nama',
		'penyedia_namalain',
		'penyedia_alamat',
		'penyedia_direktur',
		'penyedia_cp',
		'penyedia_telepon',
                'penyedia_email',
                array(
                    'header' => 'Aktif',
                    'value' => '($data->penyedia_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                ),
                array(
                    'header' => 'Verifikasi',
                    'value' => function($data){
                        echo $data->penyedia_statusverifikasi;

                    },
                    'htmlOptions' => array('style' => 'text-align:center;'),
                ),
 
	),
)); 
?>