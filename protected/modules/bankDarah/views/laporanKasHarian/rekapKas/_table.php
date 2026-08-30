<?php
$rim = 'width:600px;overflow-x:none;';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchKasHarian();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)) {
    $sort = false;
    $data = $model->searchPrintKasHarian();
    $rim = '';
    $template = "{items}";
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
?>

<div id="rekapKas">
    <div style="<?php echo $rim; ?>">
        <?php
        if (isset($caraPrint)) {
        } else {
        ?>
            <legend class="rim"> Tabel Rekap Kas Harian </legend>
        <?php } ?>
        <?php
        $this->widget($table, array(
            'id' => 'laporankasharianlab-grid',
            'dataProvider' => $data,
            'enableSorting' => $sort,
            'template' => $template,
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'mergeHeaders' => array(
                array(
                    'name' => '<p style="margin: 0; text-align: center;">PENERIMAAN KAS</p>',
                    'headerHtmlOptions' => array('style' => 'background-color:#4bb1cf;'),
                    'start' => 2, //indeks kolom 3
                    'end' => 4, //indeks kolom 4
                ),
            ),

            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                    'footerHtmlOptions' => array('colspan' => 2, 'style' => 'text-align:right;font-style:italic;'),
                    'footer' => 'JUMLAH',
                ),
                array(
                    'header' => '<p style="margin: 0; text-align: center;">URAIAN</p>',
                    'type' => 'raw',
                    'value' => '(empty($data->keterangan_closing) ? "-" : "$data->keterangan_closing" )',
                ),
                array(
                    'header' => '<p style="margin: 0; text-align: center;">TUNAI</p>',
                    'name' => 'jumlahuang',
                    'type' => 'raw',
                    //                      'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'footer' => 'sum(jumlahuang)',
                    'value' => '(empty($data->jumlahuang) ? "0" : number_format($data->jumlahuang))',
                    'htmlOptions' => array(
                        'style' => 'text-align:right',
                    ),
                ),
                array(
                    'header' => '<p style="margin: 0; text-align: center;">PIUTANG</p>',
                    'name' => 'piutang',
                    'type' => 'raw',
                    'value' => '(empty($data->piutang) ? "0" : number_format($data->piutang))',
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'footer' => 'sum(piutang)',
                    //                      'value'=>'(empty($data->terimauangmuka) ? "0" : number_format($data->terimauangmuka))',
                    'htmlOptions' => array(
                        'style' => 'text-align:right',
                    ),
                ),
                array(
                    'header' => '<p style="margin: 0; text-align: center;">TOTAL</p>',
                    'name' => 'total',
                    'type' => 'raw',
                    'value' => '(empty($data->total) ? "0" : number_format($data->total) )',
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'footer' => 'sum(total)',
                    'htmlOptions' => array(
                        'style' => 'text-align:right',
                    ),
                ),
                array(
                    'header' => '<p style="margin: 0; text-align: center;">BERSYARAT <br> PIUTANG BARU</p>',
                    'name' => 'totalpengeluaran',
                    'type' => 'raw',
                    'value' => '(empty($data->totalpengeluaran) ? "0" : number_format($data->totalpengeluaran))',
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'footer' => 'sum(totalpengeluaran)',
                    'htmlOptions' => array(
                        'style' => 'text-align:right',
                    ),
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>

</div>

<div id="detailKas">
    <div style="<?php echo $rim; ?>">
        <?php
        if (isset($caraPrint)) {
            $dataDetail = $model->searchPrintDetailKas();
        } else {
            $dataDetail = $model->searchDetailKas();
        ?>
            <legend class="rim"> Tabel Detail Kas Harian</legend>
        <?php } ?>
        <?php
        $this->widget($table, array(
            'id' => 'detaillaporankasharianlab-grid',
            'dataProvider' => $dataDetail,
            'enableSorting' => $sort,
            'template' => $template,
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                    'footerHtmlOptions' => array('colspan' => '4', 'style' => 'text-align:right;font-style:italic;'),
                    'footer' => 'Total:',
                ),
                array(
                    'header' => 'No. Reg Lab ',
                    'type' => 'raw',
                    'value' => '$data->no_pendaftaran',
                ),
                array(
                    'header' => 'Nama',
                    'type' => 'raw',
                    'value' => '$data->nama_pasien',
                ),
                array(
                    'header' => 'Kedatangan',
                    'type' => 'raw',
                    'value' => '(empty($data->keterangan_closing) ? "-" : $data->keterangan_closing)',
                ),
                array(
                    'header' => '<p style="margin: 0; text-align: center;">Piutang</p>',
                    'name' => 'piutang',
                    'type' => 'raw',
                    'value' => '(empty($data->piutang) ? "0" : number_format($data->piutang))',
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'footer' => 'sum(piutang)',
                    //                      'value'=>'(empty($data->terimauangmuka) ? "0" : number_format($data->terimauangmuka))',
                    'htmlOptions' => array(
                        'style' => 'text-align:right',
                    ),
                ),
                array(
                    'header' => '<p style="margin: 0; text-align: center;">Deposit</p>',
                    'name' => 'piutang',
                    'type' => 'raw',
                    'value' => '(empty($data->piutang) ? "0" : number_format($data->piutang))',
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'footer' => 'sum(piutang)',
                    //                      'value'=>'(empty($data->terimauangmuka) ? "0" : number_format($data->terimauangmuka))',
                    'htmlOptions' => array(
                        'style' => 'text-align:right',
                    ),
                ),
                array(
                    'header' => '<p style="margin: 0; text-align: center;">Pembayaran</p>',
                    'name' => 'jumlahuang',
                    'type' => 'raw',
                    'value' => '(empty($data->jumlahuang) ? "0" : number_format($data->jumlahuang))',
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'footer' => 'sum(jumlahuang)',
                    //                      'value'=>'(empty($data->terimauangmuka) ? "0" : number_format($data->terimauangmuka))',
                    'htmlOptions' => array(
                        'style' => 'text-align:right',
                    ),
                ),

            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>

</div>

<br>