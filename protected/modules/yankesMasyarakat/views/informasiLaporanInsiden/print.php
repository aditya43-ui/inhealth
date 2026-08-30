<?php

if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
if ($caraPrint != "PDF") {
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew', array('judulLaporan' => $judulLaporan, 'colspan' => 10));
} else {
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew', array('judulLaporan' => $judulLaporan, 'colspan' => 10));
    echo '<div style="margin-top:20px">';
    echo '</div>';
}
$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)) {
    $data = $model->searchPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $data = $model->searchPrint();
    $template = "{summary}\n{items}\n{pager}";
}

$this->widget($table, array(
    'id' => 'resumemonev-t-grid',
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
            'header' => 'Tanggal Pelaporan',
            'name' => 'insidenrs_tgllapor',
            'value' => function($data) {
                if (!empty($data->insidenrs_tgllapor)) {
                    echo MyFormatter::formatDateTimeForUser($data->insidenrs_tgllapor);
                } else {
                    echo '';
                }
            },
        ),
        array(
            'header' => 'Tanggal dan Waktu Insiden',
            'name' => 'insidenrs_tglinsiden',
            'value' => function($data) {
                if (!empty($data->insidenrs_tglinsiden)) {
                    echo MyFormatter::formatDateTimeForUser($data->insidenrs_tglinsiden);
                } else {
                    echo '';
                }
            },
        ),
        array(
            'header' => 'Instalasi / Ruangan',
            'value' => function($data) {
                $cekPendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                if (!empty($cekPendaftaran)) {
                    echo (isset($cekPendaftaran->instalasi_id) ? $cekPendaftaran->instalasi->instalasi_nama : "-") . " / " . (isset($cekPendaftaran->ruangan_id) ? $cekPendaftaran->ruangan->ruangan_nama : "-");
                } else {
                    $instalasi = !empty($data->instalasi_id) ? $data->instalasiinsiden->instalasi_nama : null;
                    $ruangan = !empty($data->ruangan_id) ? $data->ruanganinsiden->ruangan_nama : null;
                    echo $instalasi . '/<br/>' . $ruangan;
                }
            },
        ),
        array(
            'header' => 'No. Rekam Medik / Nama Pasien',
            'value' => function ($data) {
                $cekPendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                if (!empty($cekPendaftaran)) {
                    echo $cekPendaftaran->pasien->no_rekam_medik . " / <br>" . $cekPendaftaran->pasien->nama_pasien;
                } else {
                    echo!empty($data->norekammedik) ? $data->norekammedik : '-';
                    echo ' / <br>';
                    echo!empty($data->nama_pasien) ? $data->nama_pasien : '-';
                }
            }
        ),
        array(
            'header' => 'Insiden',
            'name' => 'insidenrs_nama',
            'value' => function($data) {
                if (!empty($data->insidenrs_nama)) {
                    echo $data->insidenrs_nama;
                } else {
                    echo '';
                }
            },
        ),
        array(
            'header' => 'Kronologis Insiden',
            'name' => 'insidenrs_kronologis',
            'value' => function($data) {
                if (!empty($data->insidenrs_kronologis)) {
                    echo $data->insidenrs_kronologis;
                } else {
                    echo '';
                }
            },
        ),
        array(
            'header' => 'Jenis Insiden',
            'name' => 'insidenrs_jenis',
            'value' => function($data) {
                if (!empty($data->insidenrs_jenis)) {
                    echo $data->insidenrs_jenis;
                } else {
                    echo '';
                }
            },
        ),
        array(
            'header' => 'Tempat Insiden / Lokasi Kejadian',
            'name' => 'insidenrs_jenis',
            'value' => function($data) {
                $tempat = '';
                $lokasi = '';
                if (!empty($data->lokasikejadian_id)) {
                    $cekRuangan = RuanganM::model()->findByPk($data->lokasikejadian_id);
                    $tempat = $cekRuangan->ruangan_nama;

                    $modUnitKerja = UnitkerjaruanganM::model()->findByAttributes(array('ruangan_id' => $data->lokasikejadian_id));
                    if (!empty($modUnitKerja->unitkerja_id)) {
                        $unitKerja = UnitkerjaM::model()->findByPk($modUnitKerja->unitkerja_id);
                        $lokasi = $unitKerja->namaunitkerja;
                    } else {
                        $lokasi = '';
                    }
                } else {
                    $tempat = '';
                    $lokasi = '';
                }

                echo $tempat . ' / <br>' . $lokasi;
            },
        ),
        array(
            'header' => 'Grading Risiko',
            'type' => 'raw',
            'value' => '$data->getGradingPrint($data->insidenrs_id, $data)',
            'htmlOptions' => array('style' => 'text-align:center;'),
        ),
        array(
            'header' => 'Verifikasi',
            'type' => 'raw',
            'value' => '$data->getVerifikasiPrint($data->insidenrs_id, $data)',
            'htmlOptions' => array('style' => 'text-align:center;'),
        ),
        array(
            'header' => 'Status Laporan',
            'type' => 'raw',
            'value' => '$data->getStatusPrint($data->insidenrs_id, $data)',
            'htmlOptions' => array('style' => 'text-align:center;'),
        ),
    ),
));
?>