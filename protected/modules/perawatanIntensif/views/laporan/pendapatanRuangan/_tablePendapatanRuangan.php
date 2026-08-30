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
    'mergeHeaders' => array(
        array(
            'name' => '<p style="margin: 0; text-align: center;">Tarif</p>',
            'start' => 7, //indeks kolom 3
            'end' => 8, //indeks kolom 4
        ),
    ),
    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
    'columns' => array(
        array(
            'header' => 'No.',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
            'value' => $pagination,
        ),
        array(
            'name' => 'no_rekam_medik',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(
            'name' => 'nama_pasien',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(
            'name' => 'no_pendaftaran',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(
            'name' => 'nama_pegawai',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(
            'name' => 'carabayarPenjamin',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(
            'name' => 'kelaspelayanan_nama',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'footerHtmlOptions' => array('colspan' => 7, 'style' => 'text-align:right;font-style:italic;'),
            'footer' => 'Jumlah Total',
        ),
        array(
            'header' => 'Tarif Satuan (Rp)',
            'name' => 'tarif_satuan',
            'value' => 'number_format($data->tarif_satuan)',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'htmlOptions' => array('style' => 'text-align:right;'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(tarif_satuan)',
        ),
        array(
            'header' => 'Tarif Cyto Tindakan (Rp)',
            'name' => 'tarifcyto_tindakan',
            'value' => 'number_format($data->tarifcyto_tindakan)',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'htmlOptions' => array('style' => 'text-align:right;'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(tarifcyto_tindakan)',
        ),
        array(
            'header' => 'Tarif RS Akomodasi (Rp)',
            'name' => 'tarif_rsakomodasi',
            'value' => 'number_format($data->tarif_rsakomodasi)',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'htmlOptions' => array('style' => 'text-align:right;'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(tarif_rsakomodasi)',
        ),
        array(
            'header' => 'Tarif Medis (Rp)',
            'name' => 'tarif_medis',
            'value' => 'number_format($data->tarif_medis)',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'htmlOptions' => array('style' => 'text-align:right;'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(tarif_medis)',
        ),
        array(
            'header' => 'Tarif Paramedis (Rp)',
            'name' => 'tarif_paramedis',
            'value' => 'number_format($data->tarif_paramedis)',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'htmlOptions' => array('style' => 'text-align:right;'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(tarif_paramedis)',
        ),
        array(
            'header' => 'Tarif BHP (Rp)',
            'name' => 'tarif_bhp',
            'value' => 'number_format($data->tarif_bhp)',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'htmlOptions' => array('style' => 'text-align:right;'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(tarif_bhp)',
        ),
        array(
            'header' => 'Total (Rp)',
            'name' => 'totalTarif',
            'value' => 'number_format($data->totalTarif)',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:right;'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(totalTarif)',
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>