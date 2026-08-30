<?php
$itemCssClass = 'table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
if (isset($caraPrint)) {
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
            'value' => '$row+1'
        ),
        'no_pendaftaran',
        'no_rekam_medik',
        array(
            'header' => 'Nama Pasien',
            'value' => '$data->namadepan." ".$data->nama_pasien',
        ),
        array(
            'header' => 'Umur/ <br> Jenis Kelamin',
            'type' => 'raw',
            'value' => '$data->umur."/ <br>".$data->jeniskelamin'
        ),
        array(
            'header' => 'Jenis Kasus Penyakit',
            'value' => '$data->jeniskasuspenyakit_nama',
        ),
        //            'jeniskasuspenyakit_nama',
        array(
            'header' => 'Kelas Pelayanan',
            'value' => '$data->kelaspelayanan_nama',
        ),
        //            'kelaspelayanan_nama',
        array(
            'header' => 'Jenis Penjamin / Penjamin',
            'type' => 'raw',
            'value' => '$data->carabayarPenjamin',
        ),
        //            'carabayarPenjamin',
        array(
            'header' => 'Iur Biaya (Rp)',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'value' => 'number_format($data->iurbiaya,0,",",".")',
        ),
        //            'iurbiaya',
        array(
            'header' => 'Total Biaya Pelayanan (Rp)',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'type' => 'raw',
            'value' => 'number_format($data->total,0,",",".")',
        ),
        //            'total',
        //            'alamat_pasien',   
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>