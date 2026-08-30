<?php
$itemCssClass='table table-striped table-bordered table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
$data = $model->search();
if (isset($caraPrint)){

$template = "{items}";
$sort = false;
if ($caraPrint == "EXCEL"){
$table = 'ext.bootstrap.widgets.BootExcelGridView';
}if ($caraPrint == "PDF"){
$itemCssClass='table border';
}
} else{
$data = $model->search();
$template = "{summary}\n{items}\n{pager}";
}
$data->pagination = false;
$data->sort->defaultOrder = 'jenisbarang_nama asc';

$this->widget($table,array(
'id'=>'sajenis-kelas-m-grid',
'enableSorting'=>false,
'dataProvider'=>$data,
'template'=>$template,
'enableSorting'=>$sort,
'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
		////'jenisbarang_id',
		array(
                    'header' => 'No.',
                    'value' => '$row+1',
                    ),

		'jenisbarang_nama',
		'jenisbarang_namalain',
		'jenisbarang_deskripsi',
		/*
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		'jenisbarang_aktif',
		*/
 
	),
    )); 
                    
                    
 ?>