<style>
    .table {
        border: 1px solid black;
        box-shadow: none;
        border-collapse: collapse;
    }

    .table th,
    .table td,
    .table footer {
        border: 1px solid black !important;
        color: black;
    }
</style>
<?php
if (isset($data['caraPrint'])) {
    $pagination = false;
    if ($data['caraPrint'] == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $data['judulLaporan'] . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
        $headerDefault = "";
    }
    if ($data['caraPrint'] == 'PDF') {
        $headerDefault = $this->renderPartial('application.views.headerReport.headerLaporan', array('colspan' => 6));
    }
    if ($data['caraPrint'] == 'PRINT') {
        $headerDefault = $this->renderPartial('application.views.headerReport.headerLaporan', array('colspan' => 6));
    }
} else {
    $pagination = true;
}
?>
<table style="width: 100%; border: none;">
    <tr>
        <td><?php echo $headerDefault; ?></td>
    </tr>
    <tr>
        <td align="center" style="padding: 20px;">
            <div><b><?php echo $data['judulLaporan']; ?></b></div>
            <div>Periode : <?php echo date("d-m-Y", strtotime($model->tgl_awal)); ?> s/d <?php echo date("d-m-Y", strtotime($model->tgl_akhir)); ?></div>
        </td>
    </tr>
</table>
<?php
$dataProvider = null;
if ($data['filter'] == 'all') {
    $dataProvider = $model->searchPrintPasienSudahBayar();
} else if ($data['filter'] == 'p3') {
    $dataProvider = $model->searchPrintPasienBerdasarkanPenjamin();
} else if ($data['filter'] == 'umum') {
    $dataProvider = $model->searchPrintPasienBerdasarkanUmum();
}
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
    'id' => 'semua_pencarianpasien_grid',
    'dataProvider' => $dataProvider,
    'template' => "{items}",
    'itemsCssClass' => 'table',
    'enableSorting' => false,
    'columns' => array(
        array(
            'header' => 'No.',
            'name' => 'tglbuktibayar',
            'type' => 'raw',
            'value' => '$row+1',
            'footerHtmlOptions' => array('colspan' => 14, 'style' => 'text-align:right;font-style:italic;'),
            'footer' => 'Jumlah Total',
        ),
        array(
            'header' => 'Tanggal Bukti Bayar <br> No. Bukti Bayar',
            'name' => 'tglbuktibayar',
            'type' => 'raw',
            'value' => '(isset($data->tandabuktibayar->tglbuktibayar) ? date("d/m/Y H:i:s",strtotime($data->tandabuktibayar->tglbuktibayar)) : "")."<br>".(isset($data->tandabuktibayar->nobuktibayar) ? $data->tandabuktibayar->nobuktibayar : "")',
        ),
        array(
            'name' => 'instalasi',
            'type' => 'raw',
            'value' => '(isset($data->pendaftaran->instalasi_id)?$data->pendaftaran->instalasi->instalasi_nama:"")',
        ),
        array(
            'header' => 'No. Pendaftaran / No. Rekam Medik',
            'value' => '(isset($data->pendaftaran_id)?$data->pendaftaran->no_pendaftaran:"")." / ".(isset($data->pasien_id)?$data->pasien->no_rekam_medik:"")',
        ),
        array(
            'name' => 'nama_pasien',
            'type' => 'raw',
            'value' => '(isset($data->pasien_id)?$data->pasien->nama_pasien:"")." / ".$data->nama_bin',
        ),
        array(
            'name' => 'alamat_pasien',
            'type' => 'raw',
            'value' => '(isset($data->pasien_id)?$data->pasien->alamat_pasien:"")',
        ),
        array(
            'header' => 'Jenis Penjamin / Penjamin',
            'name' => 'carabayar_nama',
            'type' => 'raw',
            'value' => '(isset($data->pendaftaran->carabayar_id)?$data->pendaftaran->carabayar->carabayar_nama:"")."<br>".(isset($data->pendaftaran->penjamin_id)?$data->pendaftaran->penjamin->penjamin_nama:"")',
        ),
        array(
            'header' => 'Total Tagihan (Rp)',
            'name' => 'total_tagihan',
            'type' => 'raw',
            'value' => 'number_format($data->totalbiayapelayanan,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Tanggungan Asuransi (Rp)',
            'name' => 'subsidi_asuransi',
            'type' => 'raw',
            'value' => 'number_format($data->totalsubsidiasuransi,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Tanggungan Pemerintah (Rp)',
            'name' => 'subsidi_pemerintah',
            'type' => 'raw',
            'value' => 'MyFormatter::formatNumberForPrint($data->totalsubsidipemerintah)',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Tanggungan Rumah Sakit (Rp)',
            'name' => 'subsidi_rs',
            'type' => 'raw',
            'value' => 'number_format($data->totalsubsidirs,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Biaya (Rp)',
            'name' => 'iur_biaya',
            'type' => 'raw',
            'value' => 'number_format($data->totaliurbiaya,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Keringanan (Rp)',
            'name' => 'discount',
            'type' => 'raw',
            'value' => 'number_format($data->totaldiscount,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Pembebasan (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->totalpembebasan,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Jumlah Pembayaran (Rp)',
            'name' => 'totalbayartindakan',
            'type' => 'raw',
            'value' => 'number_format($data->totalbayartindakan,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(totalbayartindakan)',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>