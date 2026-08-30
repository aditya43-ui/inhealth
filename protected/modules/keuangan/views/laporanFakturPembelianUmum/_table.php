<?php
//    $table = 'ext.bootstrap.widgets.BootGroupGridView';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
if (isset($caraPrint)) {
    $data = $model->searchLaporanPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    echo "<style>
                .table thead:first-child{
                        border-top:1px solid #000;        
                    }

                    thead th{
                        background:none;
                        color:#333;
                        border:1px solid #333;
                    }
                    
                    tfoot td{
                        border:1px solid #333;
                    }

                    .table th a{                        
                        color:#333;                        
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
    $itemsCssClass = 'table a';
} else {
    $data = $model->searchLaporan();
    $template = "{summary}\n{items}\n{pager}";
    $itemsCssClass = 'table table-bordered datatable';
}

$this->widget($table, array(
    'id' => 'laporan-grid',
    'dataProvider' => $data,
    'template' => $template,
    'itemsCssClass' => $itemsCssClass,
    'columns' => array(
        array(
            'header' => 'No.',
            'headerHtmlOptions' => array('style' => 'text-align:left;'),
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
            'footerHtmlOptions' => array('colspan' => 6, 'style' => 'text-align:right;'),
            'footer' => ' '
        ),
        array(
            'header' => 'Tanggal Terima/<br>No Penerimaan',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($data->tglterima)))."/<br> ".$data->nopenerimaan',
        ),
        array(
            'header' => 'Supplier',
            'value' => '$data->supplier_nama'
        ),
        array(
            'header' => 'No. Faktur',
            'value' => '$data->nofaktur'
        ),
        array(
            'header' => 'Tanggal Jatuh Tempo',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgljatuhtempo)',
        ),
        array(
            'header' => 'Keterangan Persediaan',
            'type' => 'raw',
            'value' => '$data->keterangan_persediaan',
        ),
        array(
            'header' => 'Umur Utang',
            'type' => 'raw',
            'value' => '$data->umurHutang',
            'footer' => '<b>Total Utang :</b>',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'header' => 'Total Harga (Rp)',
            'value' => 'number_format($data->totalharga,0,"",".")',
            'footer' => "<b>Rp" . number_format($model->getTotalharga(), 0, "", ".") . "</b>",
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'htmlOptions' => array('style' => 'text-align:right;')
        ),
        array(
            'header' => 'Keringanan (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->discount,0,"",".")',
            'footer' => '-',
            'footerHtmlOptions' => array('style' => 'text-align:right;color:white;'),
            'htmlOptions' => array('style' => 'text-align:right;')
        ),
        array(
            'header' => 'Pajak PPh (Rp)',
            // 'name' => 'pajakpph',
            'type' => 'raw',
            'value' => 'number_format($data->pajakpph,0,"",".")',
            'footer' => '-',
            'footerHtmlOptions' => array('style' => 'text-align:right;color:white;'),
            'htmlOptions' => array('style' => 'text-align:right;')
        ),
        array(
            'header' => 'Pajak PPN (Rp)',
            //'name' => 'pajakppn',
            'type' => 'raw',
            'value' => 'number_format($data->pajakppn,0,"",".")',
            'footer' => '-',
            'footerHtmlOptions' => array('style' => 'text-align:right;color:white;'),
            'htmlOptions' => array('style' => 'text-align:right;')
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>
<script>
    $('.integer').each(function() {
        formatNumber();
    });
</script>