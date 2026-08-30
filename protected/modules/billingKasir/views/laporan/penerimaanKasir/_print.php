<?php

if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi', array('judulLaporan' => $judulLaporan, 'periode' => 'Periode : ' . $periode, 'colspan' => 10));
if ($caraPrint != 'GRAFIK') {
    //$this->renderPartial('penerimaanKasir/_table', array('model'=>$model, 'caraPrint'=>$caraPrint)); 
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $dataProv = $model->searchTable();
    $template = "{summary}\n{items}\n{pager}";
    $sort = true;
    if (isset($caraPrint)) {
        $sort = false;
        $dataProv = $model->searchPrint();
        $template = "{items}";
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
?>
<?php $this->widget($table, array(
        'id' => 'tableLaporan',
        'dataProvider' => $dataProv,
        'enableSorting' => $sort,
        'template' => $template,
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'No.',
                'value' => '$row+1',
                'footer' => 'Total',
                'footerHtmlOptions' => array(
                    'colspan' => 7, 'style' => 'text-align: right; font-weight: bold;'
                ),
            ),
            array(
                'header' => 'No. Bukti <br> Bayar',
                'type' => 'raw',
                'value' => '$data->nobuktibayar',
                'htmlOptions' => array('style' => 'font-size:10px;'),

            ),
            array(
                'header' => 'Tanggal <br> Bukti Bayar',
                'type' => 'raw',
                'value' => 'date("d/m/Y H:i:s",strtotime($data->tglbuktibayar))',
                'htmlOptions' => array('style' => 'font-size:10px;'),
            ),
            array(
                'header' => 'Cara <br> Pembayaran',
                'type' => 'raw',
                'value' => '$data->carapembayaran',
                'htmlOptions' => array('style' => 'font-size:10px;'),
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
                'header' => 'Jumlah Pembulatan',
                'name' => 'jmlpembulatan',
                'type' => 'raw',
                'htmlOptions' => array('style' => 'text-align:right;'),
                'value' => 'number_format($data->jmlpembulatan,0,"",".")',
                'htmlOptions' => array('style' => 'font-size:10px;'),
                'footer' => 'sum(jmlpembulatan)',
            ),
            array(
                'header' => 'Biaya Administrasi (Rp)',
                'type' => 'raw',
                'name' => 'biayaadministrasi',
                'htmlOptions' => array('style' => 'text-align:right;'),
                'value' => 'number_format($data->biayaadministrasi,0,"",".")',
                'htmlOptions' => array('style' => 'font-size:10px;'),
                'footer' => 'sum(biayaadministrasi)',
            ),
            array(
                'header' => 'Biaya Meterai (Rp)',
                'type' => 'raw',
                'name' => 'biayamaterai',
                'htmlOptions' => array('style' => 'text-align:right;'),
                'value' => 'number_format($data->biayamaterai,0,"",".")',
                'htmlOptions' => array('style' => 'font-size:10px;'),
                'footer' => 'sum(biayamaterai)',
            ),
            array(
                'header' => 'Jumlah Pembayaran (Rp)',
                'name' => 'jmlpembayaran',
                'type' => 'raw',
                'htmlOptions' => array('style' => 'text-align:right;'),
                'value' => 'number_format($data->jmlpembayaran,0,"",".")',
                'htmlOptions' => array('style' => 'font-size:10px;'),
                'footer' => 'sum(jmlpembayaran)',
            ),
            array(
                'header' => 'Uang Diterima (Rp)',
                'name' => 'uangditerima',
                'type' => 'raw',
                'htmlOptions' => array('style' => 'text-align:right;'),
                'value' => 'number_format($data->uangditerima,0,"",".")',
                'htmlOptions' => array('style' => 'font-size:10px;'),
                'footer' => 'sum(uangditerima)',
            ),
            array(
                'header' => 'Uang Kembalian (Rp)',
                'name' => 'uangkembalian',
                'type' => 'raw',
                'htmlOptions' => array('style' => 'text-align:right;'),
                'value' => 'number_format($data->uangkembalian,0,"",".")',
                'htmlOptions' => array('style' => 'font-size:10px;'),
                'footer' => 'sum(uangkembalian)',
            ),
            //                'jmlpembulatan',
            //                'biayaadministrasi',
            //                'biayamaterai',
            //                'uangditerima',
            //                'uangkembalian',
            array(
                'header' => 'Ruangan Kasir',
                'value' => '$data->ruangan_nama',
                'htmlOptions' => array('style' => 'font-size:10px;'),
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
    ));
} else if ($caraPrint == 'GRAFIK') {
    echo $this->renderPartial('_grafik', array('model' => $model, 'data' => $data, 'caraPrint' => $caraPrint), true);
}

?>

<table width="100%" style='margin-top:100px;margin-left:auto;margin-right:auto;'>
    <tr>
        <td width="50%">
            <label style='float:left;'>Petugas : <?php echo $data['nama_pegawai']; ?></label>

        </td>
        <td width="50%">

            <!--<label style='float:right;'>Tanggal Print : <?php echo Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-mm-dd hh:mm:ss')); ?></label>-->

        </td>
    </tr>
</table>