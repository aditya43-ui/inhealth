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
            'header' => 'Rumah Sakit',
            'name' => 'jumlah_rs',
            'type' => 'raw',
            'value' => '($data->jumlah_rs)',
            'footer' => 'sum(jumlah_rs)',
        ),
        array(
            'header' => 'Klinik',
            'name' => 'jumlah_klinik',
            'type' => 'raw',
            'value' => '($data->jumlah_klinik)',
            'footer' => 'sum(jumlah_klinik)',
        ),
        array(
            'header' => 'Dokter',
            'name' => 'jumlah_dokter',
            'type' => 'raw',
            'value' => '($data->jumlah_dokter)',
            'footer' => 'sum(jumlah_dokter)',
        ),
        array(
            'header' => 'Puskesmas',
            'name' => 'jumlah_puskesmas',
            'type' => 'raw',
            'value' => '($data->jumlah_puskesmas)',
            'footer' => 'sum(jumlah_puskesmas)',
        )
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>