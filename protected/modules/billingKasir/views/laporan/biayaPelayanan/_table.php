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
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
        ),
        'no_pendaftaran',
        'no_rekam_medik',
        array(
            'header' => 'Nama Pasien',
            'value' => '$data->nama_pasien',
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
            'value' => 'number_format($data->iurbiaya,0,",",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        //            'iurbiaya',
        array(
            'header' => 'Total Biaya Pelayanan (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->total,0,",",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Instalasi/<br> Ruangan',
            'type' => 'raw',
            'value' => '$data->instalasi_nama."/<br> ".$data->ruangan_nama'
        ),
        //            'total',
        //            'alamat_pasien',   
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>