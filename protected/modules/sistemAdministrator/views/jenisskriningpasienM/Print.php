
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

echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>5));  

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'jenisskriningpasien_id',
		array(
                    'header' => 'No.',
                    'value' => '($this->grid->dataProvider->pagination) ? 
                                                ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                : ($row+1)',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                ),
                'jenisskriningpasien_nama',
                'jenisskriningpasien_namalainnya',
                array(
                    'name'=>'isaktif',
                    'type'=>'raw',
                    'value'=>function($data) {
                        return $data->isaktif ? "Aktif" : "Tidak Aktif";
                    },
                    'filter'=>false,
                ),
		/*
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		*/
 
	),
)); 
?>