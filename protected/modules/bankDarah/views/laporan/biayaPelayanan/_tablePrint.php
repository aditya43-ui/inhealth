<?php
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
if (isset($caraPrint)) {
    $data = $model->searchPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
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
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '$row+1'
        ),
        'no_rekam_medik',
        array(
            'header' => 'Nama Pasien / Alias',
            'value' => '$data->NamaNamaBIN',
        ),
        //            'NamaNamaBIN',
        'no_pendaftaran',
        'umur',
        'jeniskelamin',
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
        ),
        //            'carabayarPenjamin',
        array(
            'header' => 'Tanggungan Pasien (Rp)',
            'value' => 'number_format($data->iurbiaya,0,",",".")',
        ),
        //            'iurbiaya',
        array(
            'header' => 'Total Biaya Pelayanan (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->total,0,",",".")',
        ),
        //            'total',
        //            'alamat_pasien',   
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>