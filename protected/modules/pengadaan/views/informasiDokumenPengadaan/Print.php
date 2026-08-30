<?php

if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
if ($caraPrint != "PDF") {
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew', array('judulLaporan' => $judulLaporan, 'colspan' => 10));
} else {
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF', array('judulLaporan' => $judulLaporan, 'colspan' => 10));
    echo '<div style="margin-top:20px">';
    echo '</div>';
}
$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)) {
    $data = $model->searchDokumenPengadaanPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $data = $model->searchDokumenPengadaanPrint();
    $template = "{summary}\n{items}\n{pager}";
}

$this->widget($table, array(
    'id' => 'dokumenpengadaan-m-grid',
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
                'style' => 'text-align: left',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Kode Kegiatan',
            'type' => 'raw',
            'value' => function($data) {
                if (!empty($data->kode_kegiatan)) {
                    return $data->kode_kegiatan;
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: left',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Unit Kerja',
            'type' => 'raw',
            'value' => function($data) {
                if (!empty($data->namaunitkerja)) {
                    return $data->namaunitkerja;
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: left',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Pejabat Pembuat Komitmen',
            'type' => 'raw',
            'value' => function ($data) {
                $modPegawai = PegawaiM::model()->findByPk($data->pegawaippk_id);
                if (!empty($modPegawai->pegawai_id)) {
                    return $modPegawai->namaLengkap;
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: left',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Kuasa Pengguna Anggaran',
            'type' => 'raw',
            'value' => function ($data) {
                $modPegawai = PegawaiM::model()->findByPk($data->pegawaikpa_id);
                if (!empty($modPegawai->pegawai_id)) {
                    return $modPegawai->namaLengkap;
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: left',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Total Pengadaan',
            'type' => 'raw',
            'value' => function($data) {
                if (!empty($data->total_pagu)) {
                    return 'Rp ' . number_format($data->total_pagu, 2, ',', '.');
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Metode Pengadaan',
            'type' => 'raw',
            'value' => function($data) {
                if (!empty($data->metodepengadaan_final)) {
                    return $data->metodepengadaan_final;
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: left',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'RUP',
            'type' => 'raw',
            'value' => function($data) {
                if (!empty($data)) {
                    return $data->rencanaumumpengadaan_nomor;
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: left',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Kode SIRUP',
            'type' => 'raw',
            'value' => function($data){
                if (!empty($data->koderup_awal) && !empty($data->koderup_final)){
                    return $data->koderup_final;
                }else if (!empty($data->koderup_awal) && empty($data->koderup_final)){
                    return $data->koderup_awal;
                }else{
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: left',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Persiapan Pengadaan',
            'type' => 'raw',
            'value' => function($data) {
                if (!empty($data)) {
                    return $data->persiapanpengadaan_nomor;
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: left',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Kontrak',
            'type' => 'raw',
            'value' => function($data) {
                if (!empty($data)) {
                    return $data->nosuratperjanjiankerja." - ".$data->nomor_dokumen;
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: left',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Nota Dinas',
            'type' => 'raw',
            'value' => function($data) {
                if (!empty($data)) {
                    return $data->notadinaspptk_nomor." - ".$data->nomor_notadinas;
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: left',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Status',
            'type' => 'raw',
            'value' => function($data) {
                if (!empty($data->status)) {
                    return $data->status;
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: left',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
    ),
));
?>