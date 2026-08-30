<?php
$itemCssClass = 'table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)) {
    $data = $model->searchPrint();
    $template = "{items}";
    if ($caraPrint == 'EXCEL') {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
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
}
$sort = true;
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
        array(
            'header' => 'No. Pendaftaran',
            'value' => '$data->no_pendaftaran'
        ),
        array(
            'header' => 'No. Rekam Medik',
            'value' => '$data->no_rekam_medik'
        ),
        array(
            'header' => 'Nama Pasien',
            'value' => '$data->namadepan." ".$data->nama_pasien',
        ),
        //            'NamaNamaBIN',                       
        array(
            'header' => 'Umur',
            'value' => '$data->umur'
        ),
        /*  array(
                'header'=>'Jenis Kelamin',
                'value'=>'$data->jeniskelamin'
            ),            */
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
            'value' => '$data->carabayarPenjamin',
            'type' => 'raw'
        ),
        array(
            'header' => 'Biaya Pelayanan (Rp)',
            'value' => 'number_format($data->tarif_tindakan,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>