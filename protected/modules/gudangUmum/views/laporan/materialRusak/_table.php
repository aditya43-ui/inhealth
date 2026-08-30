<?php
$itemCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchMaterialRusakPrint();
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
    $data = $model->searchMaterialRusakTable();
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
            'value' => $row,
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
        ),
        array(
            'header' => 'No. Inventarisasi',
            'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
            'value' => '$data->invbarang_no',
        ),
        array(
            'header' => 'Tgl. Inventarisasi',
            'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
            'value' => 'MyFormatter::formatDateTimeForUser($data->invbarang_tgl)',
        ),
        array(
            'header' => 'Nama Barang',
            'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
            //			'value' => '$data->barang_nama',
            'value' => '$data->namaBarang($data->invbarangdet_id)',
        ),
        array(
            'header' => 'Volume',
            'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
            'value' => 'number_format($data->volume_fisik,0,"",".")',
            'htmlOptions' => array('style' => 'text-align:right;')
        ),
        array(
            'header' => 'Harga Satuan (Rp)',
            'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
            'value' => 'number_format($data->harga_satuan,0,"",".")',
            'htmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'header' => 'Jumlah Harga (Rp)',
            'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
            'value' => 'number_format($data->jumlah_harga,0,"",".")',
            'htmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'header' => 'Kondisi Barang',
            'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
            'value' => '$data->kondisi_barang',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>