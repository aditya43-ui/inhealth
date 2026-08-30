<?php
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
$pagination = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $pagination = '$row+1';
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
            'value' => $pagination,
        ),
        'no_rekam_medik',
        array(
            'header' => 'Nama Pasien /Alias',
            'value' => '$data->NamaNamaBIN',
        ),
        'no_pendaftaran',
        'umur',
        'jeniskelamin',
        array(
            'header' => 'Nama Jenis Kasus Penyakit',
            'value' => '(isset($data->jeniskasuspenyakit_nama) ? $data->jeniskasuspenyakit_nama : "")',
        ),
        array(
            'header' => 'Nama Kelas Pelayanan',
            'value' => '(isset($data->kelaspelayanan_nama) ? $data->kelaspelayanan_nama : "")',
        ),
        array(
            'header' => 'Jenis Penjamin / Penjamin',
            'value' => '(isset($data->carabayarPenjamin) ? $data->carabayarPenjamin : "")',
        ),
        array(
            'header' => 'Biaya Pelayanan (Rp)',
            'value' => 'number_format($data->tarif_tindakan)',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>