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
    'mergeHeaders' => array(
        array(
            'name' => 'Saldo',
            'start' => 5, //indeks kolom 3
            'end' => 6, //indeks kolom 4
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
            'value' => 'date("d/m/Y H:i:s", strtotime($data->tgljurnalpost)) ." /"."<br>". date("d/m/Y H:i:s", strtotime($data->tglbuktijurnal))',
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
            'footerHtmlOptions' => array('colspan' => 5, 'style' => 'text-align:right;font-style:italic;'),
            'footer' => 'Jumlah Total',
        ),
        array(
            'header' => 'Debit',
            'name' => 'saldodebit',
            'value' => 'number_format($data->saldodebit)',
            'headerHtmlOptions' => array('style' => 'text-align:right;'),
            'htmlOptions' => array('style' => 'width:100px;text-align:right', 'class' => 'currency'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(saldodebit)',
        ),
        array(
            'header' => 'Kredit',
            'name' => 'saldokredit',
            'value' => 'number_format($data->saldokredit)',
            'headerHtmlOptions' => array('style' => 'text-align:right;'),
            'htmlOptions' => array('style' => 'width:100px;text-align:right', 'class' => 'currency'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(saldokredit)',
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