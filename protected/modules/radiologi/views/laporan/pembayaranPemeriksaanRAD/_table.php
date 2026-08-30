<?php
$itemCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchLapPembayaPeriksaRADPrint();
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
    $data = $model->searchLapPembayaPeriksaRAD();
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
            'value' => '$row+1',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
        ),
        array(
            'header' => 'Tanggal <br> / No. Pendaftaran',
            'type' => 'raw',
            'value' => '$data->TanggalNoPendaftaran',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
        ),
        array(
            'header' => 'No. Rekam Medik',
            'value' => '$data->no_rekam_medik',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
        ),
        array(
            'header' => 'Nama Pasien',
            'value' => '$data->NamaPasien',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
        ),
        array(
            'header' => 'Jenis Penjamin <br> /  Penjamin',
            'type' => 'raw',
            'value' => '$data->CaraBayarPenjamin',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
        ),
        array(
            'header' => 'Dokter Pemeriksa',
            'type' => 'raw',
            'value' => '$data->NamaDokterLengkap',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
        ),
        array(
            'header' => 'Tindakan',
            'type' => 'raw',
            'value' => '$data->daftartindakan_nama',
            // 'value' => '$this->grid->getOwner()->renderPartial(\'pembayaranPemeriksaanRAD/_listTindakan\', array(\'id\'=>$data->pendaftaran_id, \'ruangan_id\'=>$data->ruangan_id))',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
        ),
        array(
            'header' => 'Tarif (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->tot_tarif,0,"",".")',
            'htmlOptions' => array('style' => 'text-align:right;'),
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
        ),
        array(
            'header' => 'Status',
            'type' => 'raw',
            'value' => '!empty($data->tindakansudahbayar_id)?"Lunas":"Belum Lunas"',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>

