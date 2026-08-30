<?php
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)) {
    $sort = false;
    $data = $model->searchPrint();
    $template = "{items}";
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
?>
<?php $this->widget($table, array(
    'id' => 'tableLaporan',
    'dataProvider' => $data,
    'enableSorting' => $sort,
    'template' => $template,
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
        ),
        array(
            'header' => 'Jenis Penjamin<br>Penjamin',
            'type' => 'raw',
            'value' => '$data->carabayar_nama.\'<br>\'.$data->penjamin_nama',
        ),
        array(
            'header' => 'No. Bukti Bayar<br>Tanggal Bukti',
            'type' => 'raw',
            'value' => '$data->nobuktibayar.\'<br>\'.date("d/m/Y H:i:s",strtotime($data->tglbuktibayar))',
        ),
        array(
            'header' => 'No. Pembayaran', //<br>Tgl. Pembayaran
            'type' => 'raw',
            'value' => '$data->nopembayaran', //.\'<br>\'.$data->tglpembayaran
        ),
        array(
            'header' => 'No. Rekam Medik<br>No. Pendaftaran',
            'type' => 'raw',
            'value' => '$data->no_rekam_medik.\'<br>\'.$data->no_pendaftaran',
        ),
        'nama_pasien',
        //                array(
        //                    'header'=>'Total Biaya Obat Alkes (Rp)',
        //                    'name'=>'totalbiayaoa',
        //                    'type'=>'raw',
        //                    'htmlOptions'=>array('style'=>'text-align:right;'),
        //                    'value'=>'number_format($data->totalbiayaoa)',
        //                ),
        array(
            'header' => 'Biaya Pelayanan (Rp)',
            'name' => 'totalbiayapelayanan',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:right;'),
            'value' => 'MyFormatter::formatNumberForPrint($data->totalbiayapelayanan)',
        ),
        //                array(
        //                    'header'=>'Uang Muka (Rp)',
        //                    //'name'=>'totalbiayapelayanan',
        //                    'type'=>'raw',
        //                    'htmlOptions'=>array('style'=>'text-align:right;'),
        //                    'value'=>'number_format(0)',
        //                ),
        array(
            'header' => 'Tanggungan Asuransi (Rp)',
            'name' => 'totalsubsidiasuransi',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:right;'),
            'value' => 'MyFormatter::formatNumberForPrint($data->totalsubsidiasuransi)',
        ),
        array(
            'header' => 'Tanggungan Pemerintah (Rp)',
            'name' => 'totalsubsidipemerintah',
            'type' => 'raw',
            'value' => 'number_format($data->totalsubsidipemerintah)',
            'htmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'header' => 'Tanggungan Rumah Sakit (Rp)',
            'name' => 'totalsubsidirs',
            'type' => 'raw',
            'value' => 'MyFormatter::formatNumberForPrint($data->totalsubsidirs)',
            'htmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'header' => 'Iur Biaya (Rp)',
            'name' => 'totaliurbiaya',
            'type' => 'raw',
            'value' => 'MyFormatter::formatNumberForPrint($data->totaliurbiaya)',
            'htmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'header' => 'Total Pembebasan (Rp)',
            'name' => 'totalpembebasan',
            'type' => 'raw',
            'value' => 'MyFormatter::formatNumberForPrint($data->totalpembebasan)',
            'htmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'header' => 'Jumlah Bayar (Rp)',
            'name' => 'totalbayartindakan',
            'type' => 'raw',
            'value' => 'MyFormatter::formatNumberForPrint($data->totalbayartindakan)',
            'htmlOptions' => array('style' => 'text-align:right;'),
        ),
        'statusbayar',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>