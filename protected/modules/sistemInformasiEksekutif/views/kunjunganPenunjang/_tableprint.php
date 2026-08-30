<?php

$itemCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model;
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    if ($caraPrint == 'PDF') {
        $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
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
    $data = $model->search();
    $template = "{summary}\n{items}\n{pager}";
}
$value = "MyFormatter::formatMonthForUser(date('Y-m',(strtotime(" . "$" . "data->periode))))";

$this->widget($table, array(
    'id' => 'tableLaporan',
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => $itemCssClass,
    'columns' => array(
        array(
            'header' => 'Periode',
            'type' => 'raw',
            'value' => $value,
            'footer' => 'Total',
        ),
        array(
            'header' => 'Lab PA',
            'name' => 'jumlah_labpa',
            'type' => 'raw',
            'value' => 'number_format($data->jumlah_labpa)',
            'footer' => 'sum(jumlah_labpa)',
        ),
        array(
            'header' => 'Lab Patologi Klinik',
            'name' => 'jumlah_laboratorium',
            'type' => 'raw',
            'value' => 'number_format($data->jumlah_laboratorium)',
            'footer' => 'sum(jumlah_laboratorium)',
        ),
        array(
            'header' => 'Lab Mikrobiologi Klinik',
            'name' => 'jumlah_mikro',
            'type' => 'raw',
            'value' => 'number_format($data->jumlah_mikro)',
            'footer' => 'sum(jumlah_mikro)',
        ),
        array(
            'header' => 'Radiologi',
            'name' => 'jumlah_radiologi',
            'type' => 'raw',
            'value' => 'number_format($data->jumlah_radiologi)',
            'footer' => 'sum(jumlah_radiologi)',
        ),
        array(
            'header' => 'Rehabilitasi Medik',
            'name' => 'jumlah_rehabilitasi',
            'type' => 'raw',
            'value' => 'number_format($data->jumlah_rehabilitasi)',
            'footer' => 'sum(jumlah_rehabilitasi)',
        ),
        array(
            'header' => 'MCU',
            'name' => 'jumlah_mcu',
            'type' => 'raw',
            'value' => 'number_format($data->jumlah_mcu)',
            'footer' => 'sum(jumlah_mcu)',
        )
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>