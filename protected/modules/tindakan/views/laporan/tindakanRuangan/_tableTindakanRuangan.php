<?php
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$sort = true;
$pagination = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $pagination = '$row+1';
    $data = $model->searchPrint();
    $template = "{items}";
    $sort = false;
    $totals = array();
    foreach ($data->data as $item) {

        if(!isset($totals['count'])) $totals['count'] = 0;
        $totals['count'] += $item['qty_tindakan']; 
    }
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $data = $model->searchTable();
    $template = "{summary}\n{items}\n{pager}";
    $totals = array();
    foreach ($data->data as $item) {

        if(!isset($totals['count'])) $totals['count'] = 0;
        $totals['count'] += $item['qty_tindakan']; 
    }

}
?>

<?php $this->widget($table, array(
    'id' => 'tableLaporan',
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
    'columns' => array(
        array(
            'header' => 'No.',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
            'value' => $pagination,
            'footerHtmlOptions' => array('colspan' => 3, 'style' => 'text-align:Center;font-style:bold;'),
            'footer' => 'Total',
        ),
        array(
            'name' => 'daftartindakan_kode',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(
            'name' => 'daftartindakan_nama',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
       
        array(
            'header' => 'Tarif Satuan',
            'name' => 'tarif_satuan',
            'value' => 'number_format($data->tarif_satuan)',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'htmlOptions' => array('style' => 'text-align:right;'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(tarif_satuan)',
        ),

        array(
            'name' => 'qty_tindakan',
            'value' => '$data->qty_tindakan',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'htmlOptions' => array('style' => 'text-align:right;'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(qty_tindakan)',
        ),
        
        array(
            'header' => 'Total',
            'name' => 'totalTarif',
            'value' => 'number_format($data->totalTarif)',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'htmlOptions' => array('style' => 'text-align:right;'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(totalTarif)',
        ),
        array(
            'name' => 'carabayar_nama',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => ' ',
        ),
        array(
            'name' => 'penjamin_nama',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => ' ',
        )
        
     

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>