<?php
//    $table = 'ext.bootstrap.widgets.BootGroupGridView';
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $data = $model->searchPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    echo "<style>            
					.table{
						border-collapse: collapse;
					}

                    .table thead:first-child{
                        border-top:1px solid #000;        
                    }

                    thead th{
                        background:none;
                        color:#333;
                        border:1px solid #333;
                    }
                    
                    .a tbody td{
                        border:1px solid #333;
                    }
                    
                    .a{
                        box-shadow:none;
                    }

                    .table tbody tr:hover td, .table tbody tr:hover th {
                        background-color: none;                        
                    }
            </style>";
    $itemsCssClass='table a';
    $row = '$row+1';
} else {
    $data = $model->searchLaporan();
    $template = "{summary}\n{items}\n{pager}";
    $itemsCssClass='table table-bordered datatable';
}

$this->widget($table, array(
    'id' => 'laporan-grid',
    'dataProvider' => $data,
    'template' => $template,
    'itemsCssClass' => $itemsCssClass,
    'enableSorting' => $sort,
    'columns' => array(
        array(
            'header' => 'No.',
            'headerHtmlOptions' => array('style' => 'text-align:left;'),
            'value' => $row
        ),
        array(
            'header' => 'Tanggal Faktur/ <br> No Faktur',
            'headerHtmlOptions' => array('style' => 'text-align:left;'),
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglfaktur)."/<br>".$data->nofaktur ',
        ),
        array(
            'header' => 'Tgl. Jatuh Tempo',
            'headerHtmlOptions' => array('style' => 'text-align:left;'),
            'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tgljatuhtempo)))',
        ),
        array(
            'header' => 'Umur Utang',
            'value' => '$data->UmurHutang',
        ),
        array(
            'header' => 'Keterangan Faktur',
            'headerHtmlOptions' => array('style' => 'text-align:left;'),
            'value' => '$data->keteranganfaktur',
        ),
        array(
            'header' => 'Status Bayar',
            'type' => 'raw',
            'value' => function ($data) {
                if (empty($data->bayarkesupplier_id)) {
                    return Params::STATUSBAYAR_BELUM_LUNAS;
                } else {
                    return Params::STATUSBAYAR_LUNAS;
                }
            }
        ),
        array(
            'header' => 'Supplier',
            'type' => 'raw',
            'headerHtmlOptions' => array('style' => 'text-align:left;'),
            'value' => '$data->supplier->supplier_nama',
            'footer' => '<b>Total</b>',
            'footerHtmlOptions' => array('style' => 'text-align:right;', 'colspan' => 7)
        ),
        //                'totharganetto',
        array(
            'header' => 'Total Harga Netto',
            'type' => 'raw',
            'headerHtmlOptions' => array('style' => 'text-align:left;'),
            'value' => 'MyFormatter::formatNumberForPrint($data->totharganetto)',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'name' => 'totharganetto',
            'footer' => 'sum(totharganetto)',
            'footerHtmlOptions' => array('style' => 'text-align:right;')
        ),
        //                'jmldiscount',
        array(
            'header' => 'Total Keringanan',
            'type' => 'raw',
            'headerHtmlOptions' => array('style' => 'text-align:left;'),
            'value' => 'MyFormatter::formatNumberForPrint($data->jmldiscount)',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'name' => 'jmldiscount',
            'footer' => 'sum(jmldiscount)',
            'footerHtmlOptions' => array('style' => 'text-align:right;')
        ),
        //                'biayamaterai',
        //                'totalpajakpph',
        array(
            'header' => 'Total PPh',
            'type' => 'raw',
            'headerHtmlOptions' => array('style' => 'text-align:left;'),
            'value' => 'MyFormatter::formatNumberForPrint($data->totalpajakpph)',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'name' => 'totalpajakpph',
            'footer' => 'sum(totalpajakpph)',
            'footerHtmlOptions' => array('style' => 'text-align:right;')
        ),
        array(
            'header' => 'Total PPN',
            'type' => 'raw',
            'headerHtmlOptions' => array('style' => 'text-align:left;'),
            'value' => 'MyFormatter::formatNumberForPrint($data->totalpajakppn)',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'name' => 'totalpajakppn',
            'footer' => 'sum(totalpajakppn)',
            'footerHtmlOptions' => array('style' => 'text-align:right;')
        ),

        //                'totalpajakppn',

        //                'totalhargabruto', 
        array(
            'header' => 'Total Harga Bruto',
            'type' => 'raw',
            'headerHtmlOptions' => array('style' => 'text-align:left;'),
            'value' => 'MyFormatter::formatNumberForPrint($data->totalhargabruto)',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'name' => 'totalhargabruto',
            'footer' => 'sum(totalhargabruto)',
            'footerHtmlOptions' => array('style' => 'text-align:right;')
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>
<script>
    $('.integer').each(function() {
        formatNumber();
    });
</script>