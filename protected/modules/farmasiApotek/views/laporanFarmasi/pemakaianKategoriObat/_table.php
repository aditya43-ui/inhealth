<?php 
/**
 * css untuk membuat text head berada d tengah
 */
echo CHtml::css('.table thead tr th{
    vertical-align:middle;
}'); ?>
<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$mergeColumns = array('obatalkes_nama');
$data = $model->searchTabelKategori();
$template = "{summary}\n{items}\n{pager}";
$sort = false;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
    $row = '$row+1';
    $sort = false;
  $data = $model->searchPrintKategori();  
  $template = "{items}";
  if ($caraPrint == "EXCEL")
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
//    'mergeColumns'=>$mergeColumns,
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(
            
            array(
                    'header'=>'No.',
                    'value' => $row,
                    'footer'=>'Jumlah',
                    'footerHtmlOptions'=>array('colspan'=>7, 'style'=>'text-align:right;'),
            ),
            array(
                'name'=>'jenisobatalkes_nama',
                'type'=>'raw',
                'value'=>'$data->jenisobatalkes_nama',
            ),
            'obatalkes_golongan',
            'obatalkes_kategori',
            'obatalkes_kode',
            'obatalkes_nama',
            array(
                'name'=>'r',
                'type'=>'raw',
                'header'=>'R',
                'value'=>'$data->r',
                // 'htmlOptions'=>array('style'=>'text-align:right;'),
                // 'headerHtmlOptions'=>array('style'=>'text-align:right;')
                
            ),
            array(
                'name'=>'qty_oa',
                'type'=>'raw',
                'header'=>'Jumlah',
                'value'=>'$data->qty_oa',
//                'value'=>'CustomFunction::formatnumber($data->qty_oa)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'headerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'sum(qty_oa)',
            ),
            
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>