<?php
$itemCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$sort = true;
if (isset($caraPrint)) {
    $data = $model->searchPrintLaporan();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }

    if ($caraPrint == 'PDF') {
        $table = 'ext.bootstrap.widgets.BootGridViewPDF';
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
                border-spacing: 0;
                padding: 0;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
    $itemCssClass = 'table border';
} else {
    $data = $model->searchTableLaporan();
    $template = "{summary}\n{items}\n{pager}";
}
?>
<?php $this->widget($table, array(
    'id' => 'tableLaporan',
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => $itemCssClass,
    'columns' => array(
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
            'htmlOptions' => array('style' => 'text-align:center'),
        ),
        array(
            'header' => 'Kode',
            'type' => 'raw',
            'value' => '$data->daftartindakan_kode',
        ),
        array(
            'header' => 'Nama Jenis Periksa',
            'type' => 'raw',
            'value' => '$data->daftartindakan_nama',
            'footerHtmlOptions' => array('colspan' => 3, 'style' => 'text-align:right;font-style:italic;'),
            'footer' => 'Total',
        ),
        array(
            'header' => 'Tarif',
            'name' => 'tarif_satuan',
            'type' => 'raw',
            'value' => 'number_format($data->tarif_satuan,0,"",".")',
            'htmlOptions' => array('style' => 'text-align:right'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(tarif_satuan)',
        ),
        array(
            'header' => 'Jumlah',
            'name' => 'qty_tindakan',
            'type' => 'raw',
            'value' => 'number_format($data->qty_tindakan,0,"",".")',
            'htmlOptions' => array('style' => 'text-align:center'),
            'footerHtmlOptions' => array('style' => 'text-align:center;'),
            'footer' => 'sum(qty_tindakan)',
        ),
        array(
            'header' => 'Total',
            'name' => 'Total',
            'type' => 'raw',
            'value' => 'number_format($data->Total,0,"",".")',
            'htmlOptions' => array('style' => 'text-align:right'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(Total)',
        ),

    ),
)); ?> 