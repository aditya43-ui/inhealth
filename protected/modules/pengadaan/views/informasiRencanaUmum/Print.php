<?php

if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
if ($caraPrint != "PDF") {
    echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan, 'colspan' => 10));
} else {
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF', array('judulLaporan' => $judulLaporan, 'colspan' => 10));
    echo '<div style="margin-top:20px">';
    echo '</div>';
}
$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)) {
    $data = $model->searchInformasiPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $data = $model->searchPrint();
    $template = "{summary}\n{items}\n{pager}";
}

$this->widget($table, array(
    'id' => 'rencanaumumpengadaan-m-grid',
    'enableSorting' => $sort,
    'dataProvider' => $data,
    'template' => $template,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'No',
            'value' => '$row+1',
        ),
        array(
            'header' => 'Nomor dan Tanggal RUP',
            'type' => 'raw',
            'value' => function($data) {
                if (!empty($data)) {
                    return $data->rencanaumumpengadaan_nomor.'<br>'.MyFormatter::formatDateTimeforUser($data->rencanaumumpengadaan_tanggal);
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Bagian / Bidang / Instalasi',
            'type' => 'raw',
            'value' => function($data) {
                if (!empty($data->instalasi_nama)) {
                    return $data->instalasi_nama;
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Kategori Pengadaan',
            'type' => 'raw',
            'value' => function($data) {
                if (!empty($data->rencanaumumpengadaan_kategori)) {
                    return $data->rencanaumumpengadaan_kategori;
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Nama Pekerjaan',
            'type' => 'raw',
            'value' => function($data) {
                if (!empty($data->nama_pekerjaan)) {
                    return $data->nama_pekerjaan;
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
       array(
            'header' => 'Pagu',
            'type' => 'raw',
            'value' => function($data) {
                if (!empty($data->total_pagu)) {
                    return 'Rp ' . number_format($data->dpa_pagu, 2, ',', '.');
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Total RAB/HPS',
            'type' => 'raw',
            'value' => function($data) {
                if (!empty($data->total_pagu)) {
                    return 'Rp ' . number_format($data->total_pagu, 2, ',', '.');
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Tahun Anggaran',
            'type' => 'raw',
            'value' => function($data) {
                if (!empty($data->periodeanggaran_id)) {
                    $periodeanggaran = PeriodeanggaranK::model()->findByPk($data->periodeanggaran_id);
                    return $periodeanggaran->tahunanggaran . " - " . $periodeanggaran->anggaran_nama;
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Sumber Dana',
            'type' => 'raw',
            'value' => function($data) {
                $sumberdana = PengadaansumberdanaT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $data->rencanaumumpengadaan_id));
                if (!empty($sumberdana)) {
                    foreach ($sumberdana as $sumber) {
                        $modSumber = SumberanggaranM::model()->findByPk($sumber->sumberanggaran_id);
                        echo $modSumber->sumberanggarannama . '<br>';
                    }
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Nomor SiRUP',
            'type' => 'raw',
            'value' => function($data) {
                if(!empty($data->kode_rup) && $data->kode_rup != 0){
                    return $data->kode_rup;
                }else{
                    return 'Belum Diumumkan';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
    ),
));
?>