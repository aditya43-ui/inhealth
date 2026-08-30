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
    'itemsCssClass' => 'table table-bordered datatable',
    'mergeHeaders' => array(
        array(
            'name' => 'Saldo',
            'start' => 6, //indeks kolom 3
            'end' => 7, //indeks kolom 4
        ),
    ),
    'columns' => array(
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$row+1',
            'htmlOptions' => array(
                'style' => 'text-align:center',
            ),
        ),
        array(
            'header' => 'Tanggal Posting/<br>Tanggal Jurnal',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgljurnalpost) ." /"."<br>". MyFormatter::formatDateTimeForUser($data->tglbuktijurnal)',
        ),
        array(
            'header' => 'Jenis Jurnal',
            'type' => 'raw',
            'value' => '$data->jenisjurnal_nama'
        ),
        array(
            'header' => 'Uraian Transaksi',
            'type' => 'raw',
            'value' => '$data->uraiantransaksi',
        ),

        array(
            'header' => 'Kode Rekening',
            'type' => 'raw',
            'value' => '$data->getKodeRekening($data->jurnalposting_id)',
        ),
        array(
            'header' => 'Nama Rekening',
            'type' => 'raw',
            'value' => '$data->getNamaRekening($data->jurnalposting_id)',
            'footerHtmlOptions' => array('colspan' => 6, 'style' => 'text-align:right;font-style:italic; font-weight: bold;'),
            'footer' => 'Jumlah Total',
        ),
        array(
            'header' => 'Debit',
            'name' => 'saldodebit',
            'value' => 'MyFormatter::formatNumberForPrint($data->saldodebit)',
            'headerHtmlOptions' => array('style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'width:100px;text-align:right', 'class' => 'currency'),
            'footerHtmlOptions' => array('style' => 'text-align:right; font-weight: bold;'),
            'footer' => $model->getTotal('saldodebit', $data),
        ),
        array(
            'header' => 'Kredit',
            'name' => 'saldokredit',
            'value' => 'MyFormatter::formatNumberForPrint($data->saldokredit)',
            'headerHtmlOptions' => array('style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'width:100px;text-align:right', 'class' => 'currency'),
            'footerHtmlOptions' => array('style' => 'text-align:right; font-weight: bold;'),
            'footer' => $model->getTotal('saldokredit', $data),
        ),
        array(
            'header' => 'Catatan',
            'type' => 'raw',
            'value' => '$data->catatan',
            'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
            'footer' => '-',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>