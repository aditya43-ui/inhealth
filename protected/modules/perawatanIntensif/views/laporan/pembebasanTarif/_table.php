<?php
$itemCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchLaporanTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $sort = false;
    $data = $model->searchLaporanPrint();
    $template = "{items}";
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
}
?>
<?php $this->widget($table, array(
    'id' => 'tableLaporan',
    'dataProvider' => $data,
    'enableSorting' => $sort,
    'template' => $template,
    'htmlOptions' => array(
        'style' => 'font-size',

    ),
    'itemsCssClass' => $itemCssClass,
    'columns' => array(
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$row+1'
        ),
        array(
            'header' => 'Tanggal Pembebasan',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpembebasan)'
        ),
        array(
            'header' => 'Tanggal Pelayanan',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)'
        ),
        array(
            'header' => 'No. Pendaftaran',
            'type' => 'raw',
            'value' => '$data->no_pendaftaran'
        ),
        array(
            'header' => 'No. Rekam Medik',
            'type' => 'raw',
            'value' => '$data->no_rekam_medik'
        ),
        array(
            'header' => 'Nama Pasien',
            'type' => 'raw',
            'value' => '$data->namadepan." ".$data->nama_pasien'
        ),
        array(
            'header' => 'Ruangan Pelayanan',
            'type' => 'raw',
            'value' => '$data->ruangan_nama'
        ),
        array(
            'header' => 'Uraian Tindakan',
            'type' => 'raw',
            'value' => '$data->daftartindakan_nama'
        ),
        array(
            'header' => 'Jumlah Tarif (Rp)',
            'type' => 'raw',
            'value' => 'number_format(($data->tarif_satuan * $data->qty_tindakan),0,"",".")',
            'htmlOptions' => array('style' => 'text-align:right;')
        ),
        array(
            'header' => 'Komponen Tarif',
            'type' => 'raw',
            'value' => '$data->komponentarif_nama'
        ),
        array(
            'header' => 'Jumlah  (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->jmlpembebasan,0,"",".")',
            'htmlOptions' => array('style' => 'text-align:right;')
        ),
        array(
            'header' => 'Nama Dokter',
            'type' => 'raw',
            'value' => '$data->dokterLengkap'
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>