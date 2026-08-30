<?php
if (($tab) != 'luar') {
    $model = $modelRS;
}
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchPrintLaporan();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $data = $model->searchTableLaporan();
    $template = "{summary}\n{items}\n{pager}";
}
?>
<div id="div_rujukanLuar">
    <?php
    if (isset($caraPrint)) {
    } else {
    ?>
        <legend class="rim">Tabel Pemeriksaan Rujukan - Dari Luar</legend>
    <?php } ?>
    <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
        'id' => 'tableRujukanLuar',
        'dataProvider' => $data,
        'template' => $template,
        'enableSorting' => $sort,
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'mergeColumns' => array(
            'no',
            'no_pendaftaran',
        ),
        'columns' => array(
            array(
                'header' => 'No.',
                'name' => 'no',
                'type' => 'raw',
                'value' => $row,
                'htmlOptions' => array('style' => 'text-align:center'),

                'footerHtmlOptions' => array('colspan' => 4, 'style' => 'text-align:right;font-style:italic;'),
                'footer' => 'Total',

            ),
            array(
                'header' => 'No. Pendaftaran Lab',
                'name' => 'no_pendaftaran',
                'type' => 'raw',
                'value' => '$data->no_pendaftaran'
            ),
            array(
                'header' => 'Nama Pasien',
                'type' => 'raw',
                'value' => '$data->nama_pasien'
            ),
            array(
                'header' => 'No. RM / Pelayanan',
                'type' => 'raw',
                'value' => '$data->no_rekam_medik." / ".$data->daftartindakan_nama'
            ),
            array(
                'header' => 'Total',
                'name' => 'total',
                'type' => 'raw',
                'value' => 'number_format($data->total,0,"",".")',
                'htmlOptions' => array('style' => 'text-align:right'),
                'footerHtmlOptions' => array('style' => 'text-align:right;font-style:italic;'),
                'footer' => 'sum(total)',
            ),
            array(
                'header' => 'Bayar',
                'name' => 'jmlbayar_tindakan',
                'type' => 'raw',
                'value' => 'number_format($data->jmlbayar_tindakan)',
                'htmlOptions' => array('style' => 'text-align:right'),
                'footerHtmlOptions' => array('style' => 'text-align:right;font-style:italic;'),
                'footer' => 'sum(jmlbayar_tindakan)',
            ),
            array(
                'header' => 'Sisa',
                'name' => 'jmlsisabayar_tindakan',
                'type' => 'raw',
                'value' => 'number_format($data->jmlsisabayar_tindakan,0,"",".")',
                'htmlOptions' => array('style' => 'text-align:right'),
                'footerHtmlOptions' => array('style' => 'text-align:right;font-style:italic;'),
                'footer' => 'sum(jmlsisabayar_tindakan)',
            ),
        ),
    )); ?>
</div>