<?php

$itemCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGroupGridView';
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
$data = $model->search();
$caraPrint = !empty($caraPrint)?$caraPrint:null;
if (!empty($caraPrint)) {
    $row = '$row+1';
    $data->pagination = false;

    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }

    if ($caraPrint == 'PDF') {
        $table = 'ext.bootstrap.widgets.BootGroupGridViewPDF';
    }

    echo "
             <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing:0px;
                padding:0px;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
    $itemCssClass = 'table border';
} else {

    $template = "{summary}\n{items}\n{pager}";
}
?>

<?php

$this->widget($table, array(
    'id' => 'tableLaporan',
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => $itemCssClass,    
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => $row,              
        ),
        array(
            'header' => 'Jenis Peralatan',
            'type' => 'raw',
            'name' => 'barang_nama',                       
        ),
        array(
            'header' => 'Tahun Perolehan',
            'type' => 'raw',
            'name' => 'tahun_perolehan',                       
        ),
        array(
            'header' => 'Sumber Dana',
            'type' => 'raw',
            'name' => 'sumberdana',         
            'footer' => '<b>Total Keseluruhan</b>',
            'footerHtmlOptions' => [
                'style' => 'text-align:right;',
                'colspan' => ($caraPrint == 'PDF')?4:1
            ]
        ),
        array(
            'header' => 'Jumlah yang Bisa Dikalibrasi',
            'type' => 'raw',
            'name' => 'jumlah',
            'htmlOptions' => [
                'style' => 'text-align:right;'
            ],
            'footerHtmlOptions' =>[
                'style' => 'text-align:right;'
            ],
            'footer' => '<b>'.$model->getTotal('jumlah').'</b>'
        ), 
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>