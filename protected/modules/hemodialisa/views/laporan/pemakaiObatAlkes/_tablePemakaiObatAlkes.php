<?php
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
   $data = $model->searchPrint();
   $template = "{items}";
   if ($caraPrint=='EXCEL') {
       $table = 'ext.bootstrap.widgets.BootExcelGridView';
   }
} else{
 $data = $model->searchTable();
//    $data = $model->search();
}
$sort=true;
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
                'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
            array(
                'header' => 'No',
                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
            ),

            'jenisobatalkes_nama',    
            'obatalkes_kategori',
            'obatalkes_golongan',
            'obatalkes_nama',
            'satuankecil_nama',
            'carabayar_nama',
//		    'qty_oa',
            array(
                'header'=>'Jumlah Obat Alkes',
                'name'=>'qty_oa',
                'value'=>'$data->qty_oa'
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>