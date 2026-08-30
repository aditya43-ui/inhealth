<div>
    <?php
    $data = $model->searchtable();
    $this->widget('ext.bootstrap.widgets.MergeHeaderGroupGridView', array(
        'id' => 'laporan-penyadapan-darah-grid',
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
        'itemsCssClass' => 'table table-bordered table-striped datatable',
        'filter' => $model,
        'columns' => array(
            array(
                'header' => 'No',
                'type' => 'raw',
                'value' => '$row+1',
                'footer' => 'Total',
                'footerHtmlOptions' => array('colspan' => 4, 'style' => 'text-align:center; font-weight: bold;'),
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:center;'),
            ),
            array(
                'header' => 'Nama Donor',
                'type' => 'raw',
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
                'type' => 'raw',
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
                'type' => 'raw',
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
                'type' => 'raw',
                'name' => 'kelompok_umur',
                'value' => function($data) {
                    if (!empty($data->kelompok_umur)) {
                        if ($data->kelompok_umur == 1) {
                            return '<i class="entypo-check" style="font-size:larger"></i>';
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
                'type' => 'raw',
                'value' => function($data) {
                    if (!empty($data->kelompok_umur)) {
                        if ($data->kelompok_umur == 2) {
                            return '<i class="entypo-check" style="font-size:larger"></i>';
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
                'type' => 'raw',
                'value' => function($data) {
                    if (!empty($data->kelompok_umur)) {
                        if ($data->kelompok_umur == 3) {
                            return '<i class="entypo-check" style="font-size:larger"></i>';
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
                'type' => 'raw',
                'value' => function($data) {
                    if (!empty($data->kelompok_umur)) {
                        if ($data->kelompok_umur == 4) {
                            return '<i class="entypo-check" style="font-size:larger"></i>';
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
                'type' => 'raw',
                'value' => function($data) {
                    if (!empty($data->kelompok_umur)) {
                        if ($data->kelompok_umur == 5) {
                            return '<i class="entypo-check" style="font-size:larger"></i>';
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
                'type' => 'raw',
                'value' => function($data) {
                    if (!empty($data->jenis_kelamin)) {
                        if (strtoupper($data->jenis_kelamin) == Params::JENIS_KELAMIN_LAKI_LAKI) {
                            return '<i class="entypo-check" style="font-size:larger"></i>';
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
                'type' => 'raw',
                'value' => function($data) {
                    if (!empty($data->jenis_kelamin)) {
                        if (strtoupper($data->jenis_kelamin) == Params::JENIS_KELAMIN_PEREMPUAN) {
                            return '<i class="entypo-check" style="font-size:larger"></i>';
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
                'type' => 'raw',
                'value' => function($data) {
                    if (!empty($data->donasi_ke)) {
                        if ($data->donasi_ke == 1) {
                            return '<i class="entypo-check" style="font-size:larger"></i>';
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
                'type' => 'raw',
                'value' => function($data) {
                    if (!empty($data->donasi_ke)) {
                        if ($data->donasi_ke > 1) {
                            return '<i class="entypo-check" style="font-size:larger"></i>';
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
                'type' => 'raw',
                'value' => function($data) {
                    if (!empty($data->jenisdonor)) {
                        if ($data->jenisdonor == "Sukarela") {
                            return '<i class="entypo-check" style="font-size:larger"></i>';
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
                'type' => 'raw',
                'value' => function($data) {
                    if (!empty($data->jenisdonor)) {
                        if ($data->jenisdonor == "Pengganti") {
                            return '<i class="entypo-check" style="font-size:larger"></i>';
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
                'type' => 'raw',
                'value' => function($data) {
                    if (!empty($data->jenisdonor)) {
                        if ($data->jenisdonor == "Autologus") {
                            return '<i class="entypo-check" style="font-size:larger"></i>';
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
                'type' => 'raw',
                'value' => function($data) {
                    if (!empty($data->gol_darah)) {
                        if (strtoupper($data->gol_darah) == "A") {
                            return '<i class="entypo-check" style="font-size:larger"></i>';
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
                'type' => 'raw',
                'value' => function($data) {
                    if (!empty($data->gol_darah)) {
                        if (strtoupper($data->gol_darah) == "B") {
                            return '<i class="entypo-check" style="font-size:larger"></i>';
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
                'type' => 'raw',
                'value' => function($data) {
                    if (!empty($data->gol_darah)) {
                        if (strtoupper($data->gol_darah) == "O") {
                            return '<i class="entypo-check" style="font-size:larger"></i>';
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
                'type' => 'raw',
                'value' => function($data) {
                    if (!empty($data->gol_darah)) {
                        if (strtoupper($data->gol_darah) == "AB") {
                            return '<i class="entypo-check" style="font-size:larger"></i>';
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
                'type' => 'raw',
                'value' => function($data) {
                    if (!empty($data->rhesus)) {
                        if (strtoupper($data->rhesus) == "POSITIF" || strtoupper($data->rhesus) == "RH+") {
                            return '<i class="entypo-check" style="font-size:larger"></i>';
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
                'type' => 'raw',
                'value' => function($data) {
                    if (!empty($data->rhesus)) {
                        if (strtoupper($data->rhesus) == "NEGATIF" || strtoupper($data->rhesus) == "RH-") {
                            return '<i class="entypo-check" style="font-size:larger"></i>';
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
                'type' => 'raw',
                'value' => function($data) {
                    if (!empty($data->nama_jenis)) {
                        if ($data->nama_jenis == "Single") {
                            return '<i class="entypo-check" style="font-size:larger"></i>';
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
                'type' => 'raw',
                'value' => function($data) {
                    if (!empty($data->nama_jenis)) {
                        if ($data->nama_jenis == "Double") {
                            return '<i class="entypo-check" style="font-size:larger"></i>';
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
                'type' => 'raw',
                'value' => function($data) {
                    if (!empty($data->nama_jenis)) {
                        if ($data->nama_jenis == "Triple") {
                            return '<i class="entypo-check" style="font-size:larger"></i>';
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
                'type' => 'raw',
                'value' => function($data) {
                    if (!empty($data->nama_jenis)) {
                        if ($data->nama_jenis == "Quadruple") {
                            return '<i class="entypo-check" style="font-size:larger"></i>';
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
                'type' => 'raw',
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
                'type' => 'raw',
                'value' => function($data) {
                    if (!empty($data->nama_pegawai)) {
                        if ($data->nama_pegawai == "ROSA RUSDIANA") {
                            return '<i class="entypo-check" style="font-size:larger"></i>';
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
                'type' => 'raw',
                'value' => function($data) {
                    if (!empty($data->nama_pegawai)) {
                        if ($data->nama_pegawai == "EMMY ROHAYATI") {
                            return '<i class="entypo-check" style="font-size:larger"></i>';
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
                'type' => 'raw',
                'value' => function($data) {
                    if (!empty($data->nama_pegawai)) {
                        if ($data->nama_pegawai == "DWI RATNA OKTAVIA") {
                            return '<i class="entypo-check" style="font-size:larger"></i>';
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
                'type' => 'raw',
                'value' => function($data) {
                    if (!empty($data->is_batalpenyadapan)) {
                        if ($data->is_batalpenyadapan == true) {
                            return '<i class="entypo-check" style="font-size:larger"></i>';
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
                'type' => 'raw',
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
        'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
            $("table").find("input[type=text]").each(function(){
                cekForm(this);
            })
            $("table").find("select").each(function(){
                cekForm(this);
            })
        }',
    ));
    ?>
</div>