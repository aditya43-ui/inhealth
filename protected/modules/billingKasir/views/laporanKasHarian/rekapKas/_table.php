<?php
$rim = '';
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

<div class="biru" id="rekapKas">
    <div class="white" style="<?php echo $rim; ?>">
        <?php
        if (isset($caraPrint)) {
        } else {
        ?>
            <!--<legend class="rim"> Tabel Rekap Kas Harian </legend>-->
        <?php } ?>
        <?php
        $this->widget($table, array(
            'id' => 'laporankasharianlab-grid',
            'dataProvider' => $data,
            'enableSorting' => $sort,
            'template' => $template,
            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
            'mergeHeaders' => array(
                array(
                    'name' => 'PENERIMAAN KAS',
                    'headerHtmlOptions' => array('style' => 'background-color:#4bb1cf;'),
                    'start' => 2, //indeks kolom 3
                    'end' => 4, //indeks kolom 4
                ),
            ),

            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                    'footerHtmlOptions' => array('colspan' => 4, 'style' => 'text-align:right;font-style:italic;'),
                    'footer' => 'JUMLAH',
                ),
                array(
                    'header' => 'Shift',
                    'value' => '!empty($data->shift_id)?$data->shift->shift_nama:"-"'
                ),
                array(
                    'header' => 'Kasir',
                    'value' => '!empty($data->pegawai_id)?$data->pegawai->nama_pegawai:"-"'
                ),
                array(
                    'header' => 'URAIAN',
                    'type' => 'raw',
                    'value' => '(empty($data->keterangan_closing) ? "-" : "$data->keterangan_closing" )',
                ),
                array(
                    'header' => 'TUNAI (Rp)',
                    'name' => 'jumlahuang',
                    'type' => 'raw',
                    //                      'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'footer' => number_format($model->getTotal('jumlahuang'), 0, "", "."),
                    'value' => '(empty($data->jumlahuang) ? "0" : number_format($data->jumlahuang,0,"","."))',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'PIUTANG (Rp)',
                    'name' => 'piutang',
                    'type' => 'raw',
                    'value' => '(empty($data->piutang) ? "0" : number_format($data->piutang,0,"","."))',
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'footer' => number_format($model->getTotal('piutang'), 0, "", "."),
                    //                      'value'=>'(empty($data->terimauangmuka) ? "0" : number_format($data->terimauangmuka))',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'TOTAL (Rp)',
                    'name' => 'total',
                    'type' => 'raw',
                    'value' => '(empty($data->total) ? "0" : number_format($data->total,0,"",".") )',
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'footer' => number_format($model->getTotal('total'), 0, "", "."),
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'BERSYARAT <br> PIUTANG BARU (Rp)',
                    'name' => 'totalpengeluaran',
                    'type' => 'raw',
                    'value' => '(empty($data->totalpengeluaran) ? "0" : number_format($data->totalpengeluaran))',
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'footer' => number_format($model->getTotal('totalpengeluaran'), 0, "", "."),
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>

</div>

<div class="biru" id="detailKas">
    <div class="white" style="<?php echo $rim; ?>">
        <?php
        if (isset($caraPrint)) {
            $dataDetail = $model->searchPrintDetailKas();
        } else {
            $dataDetail = $model->searchDetailKas();
        ?>
            <!--<legend class="rim"> Tabel Detail Kas Harian</legend>-->
        <?php } ?>
        <?php
        $this->widget($table, array(
            'id' => 'detaillaporankasharianlab-grid',
            'dataProvider' => $dataDetail,
            'enableSorting' => $sort,
            'template' => $template,
            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                    'footerHtmlOptions' => array('colspan' => '6', 'style' => 'text-align:right;font-style:italic;'),
                    'footer' => 'Total:',
                ),
                array(
                    'header' => 'Shift',
                    'value' => '!empty($data->shift_id)?$data->shift->shift_nama:"-"'
                ),
                array(
                    'header' => 'Kasir',
                    'value' => '!empty($data->pegawai_id)?$data->pegawai->nama_pegawai:"-"'
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
                    'header' => 'Piutang (Rp)',
                    'name' => 'piutang',
                    'type' => 'raw',
                    'value' => '(empty($data->piutang) ? "0" : number_format($data->piutang,0,"","."))',
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'footer' => number_format($model->getTotal('piutang'), 0, "", "."),
                    //                      'value'=>'(empty($data->terimauangmuka) ? "0" : number_format($data->terimauangmuka))',
                    'htmlOptions' => array(
                        'style' => 'text-align:right',
                    ),
                ),
                array(
                    'header' => 'Deposit (Rp)',
                    'name' => 'piutang',
                    'type' => 'raw',
                    'value' => '(empty($data->piutang) ? "0" : number_format($data->piutang,0,"","."))',
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'footer' => number_format($model->getTotal('piutang'), 0, "", "."),
                    //                      'value'=>'(empty($data->terimauangmuka) ? "0" : number_format($data->terimauangmuka))',
                    'htmlOptions' => array(
                        'style' => 'text-align:right',
                    ),
                ),
                array(
                    'header' => 'Pembayaran (Rp)',
                    'name' => 'jumlahuang',
                    'type' => 'raw',
                    'value' => '(empty($data->jumlahuang) ? "0" : number_format($data->jumlahuang,0,"","."))',
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'footer' => number_format($model->getTotal('jumlahuang'), 0, "", "."),
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