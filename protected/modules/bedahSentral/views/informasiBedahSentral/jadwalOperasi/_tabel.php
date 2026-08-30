<?php

$this->widget('ext.bootstrap.widgets.BootGroupGridView', array(
    'id' => 'reinformasipenjualanprodukpos-v-grid',
    'dataProvider' => $model->searchInformasi(),
    //	'filter'=>$model,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
        ),
        array(
            'header' => 'No. Rekam Medik/<br>No. Pendaftaran',
            'type' => 'raw',
            'value' => '(isset($data->pasien_id) ? $data->pasien->no_rekam_medik:"")." /"."<br>".(isset($data->pendaftaran_id) ? $data->pendaftaran->no_pendaftaran:"")',
        ),
        array(
            'header' => 'Nama Pasien <br>Bin - Binti',
            'type' => 'raw',
            'value' => '$data->pasien->nama_pasien." bin"."<br>".$data->pasien->nama_bin',
        ),
        array(
            'header' => 'Umur/<br>Jenis Kelamin',
            'type' => 'raw',
            'value' => '$data->pendaftaran->umur." /"."<br>".$data->pasien->jeniskelamin',
        ),
        array(
            'header' => 'Tanggal Rencana Operasi',
            'type' => 'raw',
            'value' => '$data->tglrencanaoperasi'
        ),
        array(
            'header' => 'Mulai Operasi/<br>Selesai Operasi',
            'type' => 'raw',
            'value' => '$data->mulaioperasi." / "."<br>".$data->selesaioperasi',
        ),
        array(
            'header' => 'Golongan Operasi',
            'type' => 'raw',
            'value' => '(isset($data->golonganoperasi_id)?$data->golonganoperasi->golonganoperasi_nama:"")',
        ),
        array(
            'header' => 'Jenis Operasi/<br>Operasi',
            'type' => 'raw',
            'value' => function ($data) {

                if(!empty($data->operasi_id)) {
                    return $data->operasi->kegiatanoperasi->kegiatanoperasi_nama." /"."<br>".$data->operasi->operasi_nama;
                } else {
                    return "- / -";
                }

            },
        ),
        array(
            'header' => 'Status Operasi',
            'type' => 'raw',
            'value' => '$data->statusoperasi',
        ),
        array(
            'header' => 'Operator',
            'type' => 'raw',
            'value' => function($data) {
                $peg = '';

                if (!empty($data->dokterpelaksana1_id)) {
                    $peg .= '<li>' . $data->dokter1->namaLengkap . '</li>';
                }

                $pelaksana = PelaksanaoperasiT::model()->findAll(" krubedah = '" . Params::KRUBEDAH_OPERATOR . "' AND rencanaoperasi_id = '" . $data->rencanaoperasi_id . "' ");

                if (!empty($pelaksana)) {
                    foreach ($pelaksana as $p) {
                        $peg .= '<li>' . $p->pegawai->namaLengkap . '</li>';
                    }
                }

                echo '<ul>' . $peg . "</ul>";
            }
        ),
        array(
            'header' => 'Asisten Operator',
            'type' => 'raw',
            'value' => function($data) {
                $peg = '';

                if (!empty($data->dokterpelaksana2_id)) {
                    $peg .= '<li>' . $data->dokter2->namaLengkap . '</li>';
                }

                $pelaksana = PelaksanaoperasiT::model()->findAll(" krubedah = '" . Params::KRUBEDAH_ASISTEN_OPERATOR . "' AND rencanaoperasi_id = '" . $data->rencanaoperasi_id . "' ");

                if (!empty($pelaksana)) {
                    foreach ($pelaksana as $p) {
                        $peg .= '<li>' . $p->pegawai->namaLengkap . '</li>';
                    }
                }

                echo '<ul>' . $peg . "</ul>";
            }
        ),
        array(
            'header' => 'Petugas RR',
            'type' => 'raw',
            'value' => function($data) {
                $peg = '';

                if (!empty($data->suster_id)) {
                    $peg .= '<li>' . $data->suster->namaLengkap . '</li>';
                }

                $pelaksana = PelaksanaoperasiT::model()->findAll(" krubedah = '" . Params::KRUBEDAH_PETUGAS_RR . "' AND rencanaoperasi_id = '" . $data->rencanaoperasi_id . "' ");

                if (!empty($pelaksana)) {
                    foreach ($pelaksana as $p) {
                        $peg .= '<li>' . $p->pegawai->namaLengkap . '</li>';
                    }
                }

                echo '<ul>' . $peg . "</ul>";
            }
        ),
        array(
            'header' => 'Perawat Instrument',
            'type' => 'raw',
            'value' => function($data) {
                $peg = '';

                if (!empty($data->bidan_id)) {
                    $peg .= '<li>' . $data->bidan->namaLengkap . '</li>';
                }

                $pelaksana = PelaksanaoperasiT::model()->findAll(" krubedah = '" . Params::KRUBEDAH_PERAWAT_INSTRUMENT . "' AND rencanaoperasi_id = '" . $data->rencanaoperasi_id . "' ");

                if (!empty($pelaksana)) {
                    foreach ($pelaksana as $p) {
                        $peg .= '<li>' . $p->pegawai->namaLengkap . '</li>';
                    }
                }

                echo '<ul>' . $peg . "</ul>";
            }
        ),
        array(
            'header' => 'Perawat Sirkuler',
            'type' => 'raw',
            'value' => function($data) {
                $peg = '';

                if (!empty($data->perawatsirkuler_id)) {
                    $peg .= '<li>' . $data->perawatsirkuler->namaLengkap . '</li>';
                }

                $pelaksana = PelaksanaoperasiT::model()->findAll(" krubedah = '" . Params::KRUBEDAH_PERAWAT_SIRKULER . "' AND rencanaoperasi_id = '" . $data->rencanaoperasi_id . "' ");

                if (!empty($pelaksana)) {
                    foreach ($pelaksana as $p) {
                        if ($p->pegawai_id == $data->perawatsirkuler_id)
                            continue;

                        $peg .= '<li>' . $p->pegawai->namaLengkap . '</li>';
                    }
                }

                echo '<ul>' . $peg . "</ul>";
            }
        ),
        array(
            'header' => 'Dokter Anastesi',
            'type' => 'raw',
            'value' => function($data) {
                $peg = '';

                if (!empty($data->dokteranastesi_id)) {
                    $peg .= '<li>' . $data->dokteranastesi->namaLengkap . '</li>';
                }

                $pelaksana = PelaksanaoperasiT::model()->findAll(" krubedah = '" . Params::KRUBEDAH_DOKTER_ANESTESI . "' AND rencanaoperasi_id = '" . $data->rencanaoperasi_id . "' ");

                if (!empty($pelaksana)) {
                    foreach ($pelaksana as $p) {
                        $peg .= '<li>' . $p->pegawai->namaLengkap . '</li>';
                    }
                }

                echo '<ul>' . $peg . "</ul>";
            }
        ),
        array(
            'header' => 'Penata Anastesi',
            'type' => 'raw',
            'value' => function($data) {
                $peg = '';

                if (!empty($data->paramedis_id)) {
                    $peg .= '<li>' . $data->paramedis->namaLengkap . '</li>';
                }

                $pelaksana = PelaksanaoperasiT::model()->findAll(" krubedah = '" . Params::KRUBEDAH_PENATA_ANESTESI . "' AND rencanaoperasi_id = '" . $data->rencanaoperasi_id . "' ");

                if (!empty($pelaksana)) {
                    foreach ($pelaksana as $p) {
                        $peg .= '<li>' . $p->pegawai->namaLengkap . '</li>';
                    }
                }

                echo '<ul>' . $peg . "</ul>";
            }
        ),
        array(
            'header' => 'Perawat Anastesi',
            'type' => 'raw',
            'value' => function($data) {
                $peg = '';
                $perawat = PasienanastesiT::model()->findByPk($data->pasienanastesi_id);
                if (!empty($perawat->perawatanastesi_id)) {
                    $peg .= '<li>' . $perawat->perawatanastesi->namaLengkap . '</li>';
                }

                $pelaksana = PelaksanaoperasiT::model()->findAll(" krubedah = '" . Params::KRUBEDAH_PERAWAT_ANESTESI . "' AND rencanaoperasi_id = '" . $data->rencanaoperasi_id . "' ");

                if (!empty($pelaksana)) {
                    foreach ($pelaksana as $p) {
                        $peg .= '<li>' . $p->pegawai->namaLengkap . '</li>';
                    }
                }

                echo '<ul>' . $peg . "</ul>";
            },
        ),
        array(
            'header' => 'Asisten Anastesi',
            'type' => 'raw',
            'value' => function($data) {
                $peg = '';

                $pelaksana = PelaksanaoperasiT::model()->findAll(" krubedah = '" . Params::KRUBEDAH_ASISTEN_ANESTESI . "' AND rencanaoperasi_id = '" . $data->rencanaoperasi_id . "' ");

                if (!empty($pelaksana)) {
                    foreach ($pelaksana as $p) {
                        $peg .= '<li>' . $p->pegawai->namaLengkap . '</li>';
                    }
                }

                echo '<ul>' . $peg . "</ul>";
            }
        ),
        array(
            'header' => 'Dokter Penerima Bayi',
            'type' => 'raw',
            'value' => function($data) {
                $peg = '';

                $pelaksana = PelaksanaoperasiT::model()->findAll(" krubedah = '" . Params::KRUBEDAH_DOKTER_PENERIMA_BAYI . "' AND rencanaoperasi_id = '" . $data->rencanaoperasi_id . "' ");

                if (!empty($pelaksana)) {
                    foreach ($pelaksana as $p) {
                        $peg .= '<li>' . $p->pegawai->namaLengkap . '</li>';
                    }
                }

                echo '<ul>' . $peg . "</ul>";
            }
        ),
        array(
            'header' => 'Bidan Penerima Bayi',
            'type' => 'raw',
            'value' => function($data) {
                $peg = '';

                $pelaksana = PelaksanaoperasiT::model()->findAll(" krubedah = '" . Params::KRUBEDAH_BIDAN_PENERIMA_BAYI . "' AND rencanaoperasi_id = '" . $data->rencanaoperasi_id . "' ");

                if (!empty($pelaksana)) {
                    foreach ($pelaksana as $p) {
                        $peg .= '<li>' . $p->pegawai->namaLengkap . '</li>';
                    }
                }

                echo '<ul>' . $peg . "</ul>";
            }
        ),
    /* array(
      'header'=>'Dokter Pelaksana I /'."<br>".'Dokter Pelaksana II',
      'type'=>'raw',
      'value'=>'." /"."<br>".(isset($data->dokterpelaksana2_id)?$data->dokter2->nama_pegawai:"")',
      ),
      array(
      'header'=>'Dokter Anastesi',
      'type'=>'raw',
      'value'=>'(isset($data->dokteranastesi_id) ? $data->dokteranastesi->nama_pegawai:"")',
      ), */
    //             
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
