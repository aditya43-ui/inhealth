<?php

$itemCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGroupGridView';
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
$data = $model->search();
if (isset($caraPrint)) {
    $row = '$row+1';
    $data->pagination = false;

    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }

    if ($caraPrint == 'PDF') {
        $table = 'ext.bootstrap.widgets.BootGroupGridView';
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
        'barang_nama',
        [
            'name' =>'baik',
            'htmlOptions' => [
              'style' =>'text-align:right;'
            ]
        ],
        [
           'name' =>'rusakringan',
            'htmlOptions' => [
              'style' =>'text-align:right;'
            ]
        ],
        [
           'name' =>'rusakberat',
            'htmlOptions' => [
              'style' =>'text-align:right;'
            ]
        ],
        [
           'name' =>'total',
            'htmlOptions' => [
              'style' =>'text-align:right;'
            ]
        ]
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>