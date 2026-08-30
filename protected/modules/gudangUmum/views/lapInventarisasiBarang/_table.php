<?php
$itemsCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchLaporanPrint();
    $template = "{items}";
    if ($caraPrint == 'EXCEL') {
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
                border-spacing: 0;
                padding: 0;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
    $itemsCssClass = "table border";
} else {
    $data = $model->searchLaporan();
}
?>
<?php $this->widget($table, array(
    'id' => 'laporan-grid',
    'dataProvider' => $data,
    'itemsCssClass' => $itemsCssClass,
    'template' => $template,
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => $row,
        ),
        array(
            'header' => 'No. Kode Barang',
            'value' => '$data->barang_kode',
            'type' => 'raw',
        ),
        array(
            'header' => 'Nama Barang',
            'value' => '$data->barang_nama',
            'type' => 'raw',
        ),
        array(
            'header' => 'Merk',
            'value' => '$data->barang_merk',
            'type' => 'raw',
        ),
        array(
            'header' => 'No. Seri',
            'value' => '$data->barang_noseri',
            'type' => 'raw',
        ),
        array(
            'header' => 'Satuan',
            'value' => '$data->barang_satuan',
            'type' => 'raw',
        ),
        array(
            'header' => 'Harga Netto (Rp)',
            'value' => (Params::cekHiddenHargaGudangUmum() == true) ? 'number_format($data->harga_netto,0,"",".")' : '"Hidden"',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'header' => 'Harga Jual (Rp)',
            'value' => (Params::cekHiddenHargaGudangUmum() == true) ? 'number_format($data->harga_satuan,0,"",".")' : '"Hidden"',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'header' => 'Kondisi',
            'value' => '$data->kondisi_barang',
            'type' => 'raw',
        ),
    ),
)); ?>