<?php
$table = 'ext.bootstrap.widgets.BootGroupGridView';
$sort = true;
if (isset($caraPrint)) {
    $dataProvider = $model->searchPrintLaporan();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';

    echo $this->renderPartial(
        'application.views.headerReport.headerLaporan',
        array(
            'judulLaporan' => $data['judulLaporan'],
            'periode' => $data['periode']
        )
    );
} else {
    $dataProvider = $model->searchTable();
    $template = "{summary}\n{items}\n{pager}";
}
?>
<?php
$this->widget(
    $table,
    array(
        'id' => 'tableLaporanTrans',
        'dataProvider' => $dataProvider,
        'template' => $template,
        'enableSorting' => $sort,
        'itemsCssClass' => 'table table-responsive table-striped table-bordered table-condensed',
        'mergeColumns' => array('no_rekam_medik'),
        'columns' => array(
            array(
                'header' => 'No. RM',
                'name' => 'no_rekam_medik',
                'type' => 'raw',
                'value' => 'isset($data->pasien->no_rekam_medik)?$data->pasien->no_rekam_medik:" - "',
            ),
            array(
                'header' => 'No. Pendaftaran',
                'type' => 'raw',
                'value' => 'isset($data->pendaftaran->no_pendaftaran)?$data->pendaftaran->no_pendaftaran:" - "',
            ),
            array(
                'header' => 'Tanggal Transaksi',
                'type' => 'raw',
                'value' => 'isset($data->tglpelayanan)?$data->tglpelayanan:" - "',
            ),
            array(
                'header' => 'Nama Item',
                'type' => 'raw',
                'value' => 'isset($data->obatalkes->obatalkes_nama)?$data->obatalkes->obatalkes_nama:" - "',
            ),
            array(
                'header' => 'Apotek (Rp)',
                'type' => 'raw',
                'value' => 'number_format($data->hargasatuan_oa,0,"",".")',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'header' => 'Jumlah',
                'type' => 'raw',
                'value' => '$data->qty_oa',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'header' => 'Pasien (Rp)',
                'type' => 'raw',
                'value' => 'number_format($data->hargasatuan_oa,0,"",".")',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'header' => 'Sub Total (Rp)',
                'type' => 'raw',
                'value' => 'number_format($data->hargajual_oa,0,"",".")',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'header' => 'Tanggungan P3 (Rp)',
                'type' => 'raw',
                'value' => 'number_format($data->subsidiasuransi,0,"",".")',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )
);
