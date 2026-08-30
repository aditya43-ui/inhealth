
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
		array(
			'header'=>'No.',
			'value' => '($this->grid->dataProvider->pagination) ? 
					($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
					: ($row+1)',
			'type'=>'raw',
			'htmlOptions'=>array('style'=>'text-align:right;'),
		),
                array(
                    'header' => 'Luaran Keperawatan',
                    'name'=>'luarankeperawatan_nama',
                    'value'=>'!empty($data->luarankeperawatan->luarankeperawatan_nama) ? $data->luarankeperawatan->luarankeperawatan_nama : "-"',
                ),
                array(
                    'header' =>'Ekspektasi',
                    'name'=>'tujuan_nama',
                    'value'=>'$data->tujuan_nama',
                ),
		array(
			'header'=>'Status',
			'value'=>'($data->tujuan_aktif == 1)?"Aktif":"Tidak Aktif"',
		),	
	),
)); 
?>