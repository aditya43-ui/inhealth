<style>
    @media print {
        @page { margin-top: 15px; }
        .ttd {
            page-break-inside:avoid;
        }
    }
    table{
        font-family: "Arial";
        width: 100% !important;
    }
</style>
<?php
$itemCssClass = 'table table-striped table-bordered table-condensed';
$table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
$sort = true;
if (isset($caraPrint)) {
    $data = $model->searchPrint();
    $template = "{items}";
    $sort = false;

    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }

    if ($caraPrint == "PDF") {
        $itemCssClass = 'table border';
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
                border-spacing:0px;
                padding:0px;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
    $itemCssClass = 'table border';
} else {
    $data = $model->searchPrint();
    $template = "{summary}\n{items}\n{pager}";
}
$this->widget($table, array('id' => 'sajenis-kelas-m-grid',
    'enableSorting' => false,
    'dataProvider' => $data,
    'mergeHeaders' => array(
        array(
            'name' => '<center>Lahir</center>',
            'start' => 2,
            'end' => 3,
        ),
        array(
            'name' => '<center>Kelompok Umur</center>',
            'start' => 4,
            'end' => 8,
        ),
        array(
            'name' => '<center>Jenis Kelamin</center>',
            'start' => 9,
            'end' => 10,
        ),
        array(
            'name' => '<center>Jenis Donor</center>',
            'start' => 11,
            'end' => 12,
        ),
        array(
            'name' => '<center>Motivasi Donor</center>',
            'start' => 13,
            'end' => 15,
        ),
        array(
            'name' => '<center>Golongan Darah</center>',
            'start' => 16,
            'end' => 19,
        ),
        array(
            'name' => '<center>Rhesus</center>',
            'start' => 20,
            'end' => 21,
        ),
        array(
            'name' => '<center>Jenis Kantong</center>',
            'start' => 22,
            'end' => 25,
        ),
        array(
            'name' => '<center>AFTAPER</center>',
            'start' => 27,
            'end' => 29,
        ),
    ),
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => $itemCssClass,
    'columns' => array(
        array(
            'header' => 'No',
            'value' => '$row+1',
            'footer' => 'Total',
            'footerHtmlOptions' => array('colspan' => 4, 'style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;'),
        ),
        array(
            'header' => 'Nama Donor',
            'value' => function($data) {
                if (!empty($data->nama_lengkap)) {
                    return $data->nama_lengkap;
                }
            },
            'headerHtmlOptions' => array('style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;'),
        ),
        array(
            'header' => 'Tgl',
            'value' => function($data) {
                if (!empty($data->tgllahir)) {
                    return date('d/m/Y', strtotime($data->tgllahir));
                }
            },
            'headerHtmlOptions' => array('style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;'),
        ),
        array(
            'header' => 'Umur',
            'value' => function($data) {
                if (!empty($data->umur)) {
                    return $data->umur;
                }
            },
            'headerHtmlOptions' => array('style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;'),
        ),
        array(
            'header' => '1',
            'value' => function($data) {
                if (!empty($data->kelompok_umur)) {
                    if ($data->kelompok_umur == 1) {
                        return 'v';
                    }
                }
            },
            'footer' => $model->getTotalKelumur1('kelompok_umur', $data),
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => '2',
            'value' => function($data) {
                if (!empty($data->kelompok_umur)) {
                    if ($data->kelompok_umur == 2) {
                        return 'v';
                    }
                }
            },
            'footer' => $model->getTotalKelumur2('kelompok_umur', $data),
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => '3',
            'value' => function($data) {
                if (!empty($data->kelompok_umur)) {
                    if ($data->kelompok_umur == 3) {
                        return 'v';
                    }
                }
            },
            'footer' => $model->getTotalKelumur3('kelompok_umur', $data),
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => '4',
            'value' => function($data) {
                if (!empty($data->kelompok_umur)) {
                    if ($data->kelompok_umur == 4) {
                        return 'v';
                    }
                }
            },
            'footer' => $model->getTotalKelumur4('kelompok_umur', $data),
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => '5',
            'value' => function($data) {
                if (!empty($data->kelompok_umur)) {
                    if ($data->kelompok_umur == 5) {
                        return 'v';
                    }
                }
            },
            'footer' => $model->getTotalKelumur5('kelompok_umur', $data),
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => 'Lk',
            'value' => function($data) {
                if (!empty($data->jenis_kelamin)) {
                    if (strtoupper($data->jenis_kelamin) == Params::JENIS_KELAMIN_LAKI_LAKI) {
                        return 'v';
                    }
                }
            },
            'footer' => $model->getTotalJKL('jenis_kelamin', $data),
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => 'Pr',
            'value' => function($data) {
                if (!empty($data->jenis_kelamin)) {
                    if (strtoupper($data->jenis_kelamin) == Params::JENIS_KELAMIN_PEREMPUAN) {
                        return 'v';
                    }
                }
            },
            'footer' => $model->getTotalJKP('jenis_kelamin', $data),
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => 'Baru',
            'value' => function($data) {
                if (!empty($data->donasi_ke)) {
                    if ($data->donasi_ke == 1) {
                        return 'v';
                    }
                }
            },
            'footer' => $model->getTotalDonasiBaru('donasi_ke', $data),
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => 'Rutin',
            'value' => function($data) {
                if (!empty($data->donasi_ke)) {
                    if ($data->donasi_ke > 1) {
                        return 'v';
                    }
                }
            },
            'footer' => $model->getTotalDonasiLama('donasi_ke', $data),
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => 'Skrl',
            'value' => function($data) {
                if (!empty($data->jenisdonor)) {
                    if ($data->jenisdonor == "Sukarela") {
                        return 'v';
                    }
                }
            },
            'footer' => $model->getTotalSkrl('jenisdonor', $data),
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => 'Pggt',
            'value' => function($data) {
                if (!empty($data->jenisdonor)) {
                    if ($data->jenisdonor == "Pengganti") {
                        return 'v';
                    }
                }
            },
            'footer' => $model->getTotalPggt('jenisdonor', $data),
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => 'Auto',
            'value' => function($data) {
                if (!empty($data->jenisdonor)) {
                    if ($data->jenisdonor == "Autologus") {
                        return 'v';
                    }
                }
            },
            'footer' => $model->getTotalAuto('jenisdonor', $data),
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => 'A',
            'value' => function($data) {
                if (!empty($data->gol_darah)) {
                    if (strtoupper($data->gol_darah) == "A") {
                        return 'v';
                    }
                }
            },
            'footer' => $model->getTotalGolA('gol_darah', $data),
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => 'B',
            'value' => function($data) {
                if (!empty($data->gol_darah)) {
                    if (strtoupper($data->gol_darah) == "B") {
                        return 'v';
                    }
                }
            },
            'footer' => $model->getTotalGolB('gol_darah', $data),
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => 'O',
            'value' => function($data) {
                if (!empty($data->gol_darah)) {
                    if (strtoupper($data->gol_darah) == "O") {
                        return 'v';
                    }
                }
            },
            'footer' => $model->getTotalGolO('gol_darah', $data),
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => 'AB',
            'value' => function($data) {
                if (!empty($data->gol_darah)) {
                    if (strtoupper($data->gol_darah) == "AB") {
                        return 'v';
                    }
                }
            },
            'footer' => $model->getTotalGolAB('gol_darah', $data),
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => 'Pos',
            'value' => function($data) {
                if (!empty($data->rhesus)) {
                    if (strtoupper($data->rhesus) == "POSITIF" || strtoupper($data->rhesus) == "RH+") {
                        return 'v';
                    }
                }
            },
            'footer' => $model->getTotalPos('rhesus', $data),
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => 'Neg',
            'value' => function($data) {
                if (!empty($data->rhesus)) {
                    if (strtoupper($data->rhesus) == "NEGATIF" || strtoupper($data->rhesus) == "RH-") {
                        return 'v';
                    }
                }
            },
            'footer' => $model->getTotalNeg('rhesus', $data),
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => 'SG',
            'value' => function($data) {
                if (!empty($data->nama_jenis)) {
                    if ($data->nama_jenis == "Single") {
                        return 'v';
                    }
                }
            },
            'footer' => $model->getTotalSG('nama_jenis', $data),
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => 'DB',
            'value' => function($data) {
                if (!empty($data->nama_jenis)) {
                    if ($data->nama_jenis == "Double") {
                        return 'v';
                    }
                }
            },
            'footer' => $model->getTotalDB('nama_jenis', $data),
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => 'TR',
            'value' => function($data) {
                if (!empty($data->nama_jenis)) {
                    if ($data->nama_jenis == "Triple") {
                        return 'v';
                    }
                }
            },
            'footer' => $model->getTotalTR('nama_jenis', $data),
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => 'QD',
            'value' => function($data) {
                if (!empty($data->nama_jenis)) {
                    if ($data->nama_jenis == "Quadruple") {
                        return 'v';
                    }
                }
            },
            'footer' => $model->getTotalQD('nama_jenis', $data),
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => 'Nomor Kantong',
            'value' => function($data) {
                if (!empty($data->nomorbarcode_utama)) {
                    return $data->nomorbarcode_utama;
                }
            },
            'footer' => " ",
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => 'Rs',
            'value' => function($data) {
                if (!empty($data->nama_pegawai)) {
                    if ($data->nama_pegawai == "ROSA RUSDIANA") {
                        return 'v';
                    }
                }
            },
            'footer' => $model->getTotalRs('nama_pegawai', $data),
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => 'Emy',
            'value' => function($data) {
                if (!empty($data->nama_pegawai)) {
                    if ($data->nama_pegawai == "EMMY ROHAYATI") {
                        return 'v';
                    }
                }
            },
            'footer' => $model->getTotalEmy('nama_pegawai', $data),
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => 'Rtn',
            'value' => function($data) {
                if (!empty($data->nama_pegawai)) {
                    if ($data->nama_pegawai == "DWI RATNA OKTAVIA") {
                        return 'v';
                    }
                }
            },
            'footer' => $model->getTotalRtn('nama_pegawai', $data),
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => 'Gagal',
            'value' => function($data) {
                if (!empty($data->is_batalpenyadapan)) {
                    if ($data->is_batalpenyadapan == true) {
                        return 'v';
                    }
                }
            },
            'footer' => $model->getTotalGagal('is_batalpenyadapan', $data),
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
        array(
            'header' => 'Keterangan',
            'value' => function($data) {
                if (!empty($data->ket_observasi)) {
                    return $data->ket_observasi;
                }
            },
            'footer' => " ",
            'footerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'headerHtmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
            'htmlOptions' => array('style' => 'text-align:center; font-weight: bold;'),
        ),
    ),
));
?>