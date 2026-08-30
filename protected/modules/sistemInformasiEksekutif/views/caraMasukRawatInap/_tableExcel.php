<?php

$itemCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.MergeHeaderGroupGridViewRp';
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchTabelPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    if ($caraPrint == 'PDF') {
        $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridViewRp';
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
    $data = $model->searchTabelPrint();
    $template = "{summary}\n{items}\n{pager}";
}


$this->widget($table, array(
    'id' => 'dashboardpengadaan-v-grid',
    'replaceUrl' => true,
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => $itemCssClass,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Periode',
            'type' => 'raw',
            'value' => "MyFormatter::formatMonthForUser(date('Y-m',(strtotime(" . "$" . "data->periode))))",
            'footer' => 'Total',
        ),
        array(
            'header' => 'Melalui Rawat Darurat',
            'name' => 'jumlah_rd',
            'type' => 'raw',
            'value' => 'number_format($data->jumlah_rd)',
            'footer' => 'sum(jumlah_rd)',
        ),
        array(
            'header' => 'Melalui Rawat Jalan',
            'name' => 'jumlah_rj',
            'type' => 'raw',
            'value' => 'number_format($data->jumlah_rj)',
            'footer' => 'sum(jumlah_rj)',
        )
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>