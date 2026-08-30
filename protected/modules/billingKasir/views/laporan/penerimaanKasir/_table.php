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
    'htmlOptions' => array(
        'style' => 'font-size',

    ),
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'No. Bukti <br> Bayar',
            'type' => 'raw',
            'value' => '$data->nobuktibayar',
            'htmlOptions' => array('style' => 'text-align: right;'),

        ),
        array(
            'header' => 'Tanggal <br> Bukti Bayar',
            'type' => 'raw',
            'value' => 'date("d/m/Y H:i:s",strtotime($data->tglbuktibayar))',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Cara <br> Pembayaran',
            'type' => 'raw',
            'value' => '$data->carapembayaran',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Dari Nama BKM',
            'value' => '$data->darinama_bkm',
        ),
        array(
            'header' => 'Alamat BKM',
            'value' => '$data->alamat_bkm',
        ),
        array(
            'header' => 'Sebagai Pembayar BKM',
            'value' => '$data->sebagaipembayaran_bkm',
        ),
        array(
            'header' => 'Jumlah Pembulatan (Rp)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:right;'),
            'value' => 'number_format($data->jmlpembulatan,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Biaya Administrasi (Rp)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:right;'),
            'value' => 'number_format($data->biayaadministrasi,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Biaya Meterai (Rp)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:right;'),
            'value' => 'number_format($data->biayamaterai,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Jumlah Pembayaran (Rp)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:right;'),
            'value' => 'number_format($data->jmlpembayaran,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Uang Diterima (Rp)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:right;'),
            'value' => 'number_format($data->uangditerima,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Uang Kembalian (Rp)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:right;'),
            'value' => 'number_format($data->uangkembalian,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        //                'jmlpembulatan',
        //                'biayaadministrasi',
        //                'biayamaterai',
        //                'uangditerima',
        //                'uangkembalian',
        array(
            'header' => 'Ruangan Kasir',
            'value' => '$data->ruangan_nama',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Nama Shift',
            'value' => '$data->shift_nama',
        ),
        array(
            'header' => 'Kasir',
            'value' => function ($data) {
                $cek = TandabuktibayarT::model()->findByPk($data->tandabuktibayar_id);

                if (!empty($cek)) {
                    $peg = LoginpemakaiK::model()->findByPk($cek->create_loginpemakai_id);

                    if (!empty($peg)) {
                        return $peg->pegawai->namaLengkap;
                    } else {
                        $peg->nama_pemakai;
                    }
                }
            }

        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>