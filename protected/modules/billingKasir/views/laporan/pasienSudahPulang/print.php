<?php
if (isset($data['caraPrint'])) {
    if ($data['caraPrint'] == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $data['judulLaporan'] . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
        $headerDefault = "";
    }

    if ($data['caraPrint'] == 'PDF') {
        $headerDefault = $this->renderPartial('application.views.headerReport.headerDefault', array('width' => 1024));
    }

    if ($data['caraPrint'] == 'PRINT') {
        $headerDefault = $this->renderPartial('application.views.headerReport.headerDefault');
    }
}
?>
<table>
    <tr>
        <td><?php echo $headerDefault; ?></td>
    </tr>
    <tr>
        <td align="center" style="padding: 20px;">
            <div><b><?php echo $data['judulLaporan']; ?></b></div>
            <div>Periode : <?php echo date("d-m-Y", strtotime($model->tgl_awal)); ?> s/d <?php echo date("d-m-Y", strtotime($model->tgl_akhir)); ?></div>
        </td>
    </tr>
    <tr>
        <td>
            <?php
            // $dataProvider = null;
            //                if($data['filter'] == 'all')
            //                {
            //                    $dataProvider = $model->searchPasienSudahPulang();
            //                }
            //                else if($data['filter'] == 'p3')
            //                {
            //                    $dataProvider = $model->searchPasienBerdasarkanPenjamin();
            //                }
            //                else if($data['filter'] == 'umum')
            //                {
            //                    $dataProvider = $model->searchPasienBerdasarkanUmum();
            //                }
            $dataProvider = $model->searchPasienSudahPulang();

            $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                'id' => 'semua_pencarianpasien_grid',
                'dataProvider' => $model->searchPrintPasienSudahPulang(),
                'template' => "{items}",
                'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                'columns' => array(
                    array(
                        'header' => 'Tgl. Masuk',
                        'name' => 'tgl_pendaftaran',
                        'type' => 'raw',
                        'value' => '$data->tgl_pendaftaran',
                        'footerHtmlOptions' => array('colspan' => 9, 'style' => 'text-align:right;font-weight:bold;'),
                        'footer' => 'Jumlah Total',

                    ),
                    array(
                        'header' => 'Tgl. Keluar',
                        'name' => 'tglpulang',
                        'type' => 'raw',
                        'value' => '$data->tglpulang',
                    ),
                    array(
                        'header' => 'No. Rekam Medik',
                        'name' => 'no_rekam_medik',
                        'type' => 'raw',
                        'value' => '$data->no_rekam_medik',
                    ),
                    array(
                        'header' => 'No. Pasien',
                        'name' => 'pasien_id',
                        'type' => 'raw',
                        'value' => '$data->pasien_id',
                    ),
                    array(
                        'header' => 'Nama / Alias',
                        'name' => 'pasien_id',
                        'type' => 'raw',
                        'value' => '$data->namadepan." ".$data->nama_pasien ." / ".$data->nama_bin',

                    ),
                    array(
                        'header' => 'Jenis Penjamin',
                        'name' => 'carabayar_nama',
                        'type' => 'raw',
                        'value' => '$data->carabayar_nama',
                    ),
                    array(
                        'header' => 'Penjamin',
                        'name' => 'penjamin_nama',
                        'type' => 'raw',
                        'value' => '$data->penjamin_nama',
                    ),
                    array(
                        'header' => 'Unit Pelayanan',
                        'name' => 'ruangan_nama',
                        'type' => 'raw',
                        'value' => '$data->ruangan_nama',
                        'footerHtmlOptions' => array('style' => 'text-align:right;font-weight:bold;'),
                        // 'footer'=>'',
                    ),
                    array(
                        'header' => 'Status Pembayaran',
                        //  'name'=>'ruangan_nama',
                        'type' => 'raw',
                        'value' => '$data->status',

                        //   'value' => array($data, "status"),
                        'footerHtmlOptions' => array('style' => 'text-align:right;font-weight:bold;'),
                        // 'footer'=>'',
                    ),
                    array(
                        'header' => 'Jml Tagihan (Rp)',
                        'name' => 'tarif_tindakan',
                        'type' => 'raw',
                        //'value'=>'$data->tarif_tindakan',
                        'value' => 'number_format($data->tarif_tindakan)',
                        'htmlOptions' => array('style' => 'text-align:right;'),
                        'footerHtmlOptions' => array('style' => 'text-align:right;font-weight:bold;'),
                        'footer' => 'sum(tarif_tindakan)',
                    ),
                    array(
                        'header' => 'Tanggungan Pasien (Rp)',
                        'name' => 'iurbiaya_tindakan',
                        'type' => 'raw',
                        //'value'=>'$data->iurbiaya_tindakan',
                        'value' => 'number_format($data->iurbiaya_tindakan)',
                        'htmlOptions' => array('style' => 'text-align:right;'),
                        'footerHtmlOptions' => array('style' => 'text-align:right;font-weight:bold;'),
                        'footer' => 'sum(iurbiaya_tindakan)',

                    ),
                    array(
                        'header' => 'Tanggungan Asuransi (Rp)',
                        'name' => 'subsidiasuransi_tindakan',
                        'type' => 'raw',
                        //'value'=>'$data->subsidiasuransi_tindakan',
                        'value' => 'number_format($data->subsidiasuransi_tindakan)',
                        'htmlOptions' => array('style' => 'text-align:right;'),
                        'footerHtmlOptions' => array('style' => 'text-align:right;font-weight:bold;'),
                        'footer' => 'sum(subsidiasuransi_tindakan)',
                    ),

                ),
                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
            ));
            ?>
        </td>
    </tr>
</table>