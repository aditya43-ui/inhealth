<?php
$dataProv = $model->searchLaporanPrint();
if ($caraPrint == 'GRAFIK' && $caraPrint != "PRINT") {
    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
    echo $this->renderPartial('_grafik', array('model' => $model, 'data' => $data, 'caraPrint' => $caraPrint), true);
}

?>

<?php

$itemCssClass = 'table border';
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'colspan' => 4));
}

echo "
            <style>
                .border th, .border td{
                    border:1px solid #000;
                }
                .table thead:first-child{
                    border-top:1px solid #000;        
                }

                thead th{
                    background:none;
                    color:#333;
                }

                .border {
                    box-shadow:none;
                    border-spacing: 0;
                    padding: 0;
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>";
$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)) {
    $data = $model->searchPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
} else {
    $data = $model->searchPrint();
    $template = "{summary}\n{items}\n{pager}";
}
if ($caraPrint == 'PRINT' && $caraPrint != "GRAFIK") {


?>

    <table style="width: 100%; border: none;">
        <thead>
            <tr>
                <td>
                    <div class="header"><?php
                                        if ($caraPrint != "PDF" && $caraPrint != "EXCEL" && $caraPrint != "GRAFIK") {
                                            echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'colspan' => 10));
                                        } ?></div>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="content">


                        <?php $this->widget($table, array(
                            'id' => 'tableLaporan',
                            'dataProvider' => $dataProv,
                            'enableSorting' => $sort,
                            'template' => $template,
                            'itemsCssClass' => $itemCssClass,
                            'columns' => array(
                                array(
                                    'header' => 'No.',
                                    'type' => 'raw',
                                    'value' => '$row+1'
                                ),
                                array(
                                    'header' => 'Tanggal Pembebasan',
                                    'type' => 'raw',
                                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglpembebasan)'
                                ),
                                array(
                                    'header' => 'Tanggal Pelayanan',
                                    'type' => 'raw',
                                    'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)'
                                ),
                                array(
                                    'header' => 'No. Pendaftaran',
                                    'type' => 'raw',
                                    'value' => '$data->no_pendaftaran'
                                ),
                                array(
                                    'header' => 'No. Rekam Medik',
                                    'type' => 'raw',
                                    'value' => '$data->no_rekam_medik'
                                ),
                                array(
                                    'header' => 'Nama Pasien',
                                    'type' => 'raw',
                                    'value' => '$data->namadepan." ".$data->nama_pasien'
                                ),
                                array(
                                    'header' => 'Ruangan Pelayanan',
                                    'type' => 'raw',
                                    'value' => '$data->ruangan_nama'
                                ),
                                array(
                                    'header' => 'Uraian Tindakan',
                                    'type' => 'raw',
                                    'value' => '$data->daftartindakan_nama'
                                ),
                                array(
                                    'header' => 'Jumlah Tarif (Rp)',
                                    'type' => 'raw',
                                    'value' => 'number_format(($data->tarif_satuan * $data->qty_tindakan),0,"",".")',
                                    'htmlOptions' => array('style' => 'text-align:right;')
                                ),
                                array(
                                    'header' => 'Komponen Tarif',
                                    'type' => 'raw',
                                    'value' => '$data->komponentarif_nama'
                                ),
                                array(
                                    'header' => 'Jumlah Pembebasan (Rp)',
                                    'type' => 'raw',
                                    'value' => 'number_format($data->jmlpembebasan,0,"",".")',
                                    'htmlOptions' => array('style' => 'text-align:right;')
                                ),
                                array(
                                    'header' => 'Nama Dokter',
                                    'type' => 'raw',
                                    'value' => '$data->dokterLengkap'
                                ),

                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                        )); ?>

                    </div>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td>
                    <div class="footer-space">&nbsp;</div>
                </td>
            </tr>
        </tfoot>
    </table>
    <div class="">
    </div>
    <div class="footer">

        <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>

    </div>

<?php
}
if ($caraPrint == 'PDF') {
    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'colspan' => 10));
    $this->widget($table, array(
        'id' => 'tableLaporan',
        'dataProvider' => $dataProv,
        'enableSorting' => $sort,
        'template' => $template,
        'itemsCssClass' => $itemCssClass,
        'columns' => array(
            array(
                'header' => 'No.',
                'type' => 'raw',
                'value' => '$row+1'
            ),
            array(
                'header' => 'Tanggal Pembebasan',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tglpembebasan)'
            ),
            array(
                'header' => 'Tanggal Pelayanan',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)'
            ),
            array(
                'header' => 'No. Pendaftaran',
                'type' => 'raw',
                'value' => '$data->no_pendaftaran'
            ),
            array(
                'header' => 'No. Rekam Medik',
                'type' => 'raw',
                'value' => '$data->no_rekam_medik'
            ),
            array(
                'header' => 'Nama Pasien',
                'type' => 'raw',
                'value' => '$data->namadepan." ".$data->nama_pasien'
            ),
            array(
                'header' => 'Ruangan Pelayanan',
                'type' => 'raw',
                'value' => '$data->ruangan_nama'
            ),
            array(
                'header' => 'Uraian Tindakan',
                'type' => 'raw',
                'value' => '$data->daftartindakan_nama'
            ),
            array(
                'header' => 'Jumlah Tarif (Rp)',
                'type' => 'raw',
                'value' => 'number_format(($data->tarif_satuan * $data->qty_tindakan),0,"",".")',
                'htmlOptions' => array('style' => 'text-align:right;')
            ),
            array(
                'header' => 'Komponen Tarif',
                'type' => 'raw',
                'value' => '$data->komponentarif_nama'
            ),
            array(
                'header' => 'Jumlah Pembebasan (Rp)',
                'type' => 'raw',
                'value' => 'number_format($data->jmlpembebasan,0,"",".")',
                'htmlOptions' => array('style' => 'text-align:right;')
            ),
            array(
                'header' => 'Nama Dokter',
                'type' => 'raw',
                'value' => '$data->dokterLengkap'
            ),

        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
}


?>