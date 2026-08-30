<?php

$itemCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGroupGridView';
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
$data = $model->searchLaporan();
if (isset($caraPrint)) {
    $row = '$row+1';
    $data->pagination->pageSize = $data->totalItemCount;

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
            'value' => '$data["no"]',            
        ),
        array(
            'header' => 'Lokasi',
            'type' => 'raw',
            'name' => 'lokasiaset_namalokasi',           
            'footer'=>'<b>Total Keseluruhan</b>'
        ),
        array(
            'header' => 'Total CM',
            'type' => 'raw',
            'name' => 'total_cm',
            'htmlOptions' => [
                'style' => 'text-align:right;'
            ],
            'footerHtmlOptions' =>[
                'style' => 'text-align:right;'
            ],
            'footer' => '<b>'.$model->getTotal('total_cm').'</b>'
        ),
        
        array(
            'header' => 'Total PM',
            'type' => 'raw',
            'name' => 'total_pm',
            'htmlOptions' => [
                'style' => 'text-align:right;'
            ],
            'footerHtmlOptions' =>[
                'style' => 'text-align:right;'
            ],
            'footer' => '<b>'.$model->getTotal('total_pm').'</b>'
        ),        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>