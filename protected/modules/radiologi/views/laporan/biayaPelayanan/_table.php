<?php
$itemCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchPrint();
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
    $data = $model->searchTable();
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
            'value' => $row
        ),
        array(
            'header' => 'Tanggal/<br> No. Pendaftaran',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/ <br>".$data->no_pendaftaran',
            'headerHtmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'name' => 'no_rekam_medik',
            'headerHtmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'header' => 'Nama Pasien',
            'value' => '$data->namadepan." ".$data->nama_pasien',
            'headerHtmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'header' => 'Umur/ <br> Jenis Kelamin',
            'type' => 'raw',
            'value' => '$data->umur."/ <br>".$data->jeniskelamin',
            'headerHtmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'header' => 'Jenis Kasus Penyakit',
            'value' => '$data->jeniskasuspenyakit_nama',
            'headerHtmlOptions' => array('style' => 'text-align:center;')
        ),
        //            'jeniskasuspenyakit_nama',
        array(
            'header' => 'Kelas Pelayanan',
            'value' => '$data->kelaspelayanan_nama',
            'headerHtmlOptions' => array('style' => 'text-align:center;')
        ),
        //            'kelaspelayanan_nama',
        array(
            'header' => 'Jenis Penjamin / Penjamin',
            'type' => 'raw',
            'value' => '$data->carabayarPenjamin',
            'headerHtmlOptions' => array('style' => 'text-align:center;')
        ),
        //            'carabayarPenjamin',
        array(
            'header' => 'Iur Biaya (Rp)',
            'value' => 'number_format($data->iurbiaya,0,",",".")',
            'headerHtmlOptions' => array('style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        //            'iurbiaya',
        array(
            'header' => 'Total Biaya Pelayanan (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->total,0,",",".")',
            'headerHtmlOptions' => array('style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        //            'total',
        //            'alamat_pasien',   
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>