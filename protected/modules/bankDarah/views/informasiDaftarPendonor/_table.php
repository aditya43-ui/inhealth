<?php 
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
    'id' => 'daftarpendonor-grid',
    'replaceUrl' => true,
    'dataProvider' => $model->searchInformasi(), 'mergeHeaders' => array(
        array(
            'name' => '<center>Golongan Darah</center>',
            'start' => 10,
            'end' => 11,
        ),
    ),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => '<center>No.</center>',
            'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
            'htmlOptions' => array('style' => 'text-align:center;width:30px;'),
            'type' => 'raw',
        ),
        array(
            'header' => 'Tanggal Pendaftaran / No. Formulir',
            'value' => function($data) {
                echo MyFormatter::formatDateTimeForUser($data->waktu_pendaftaran) . ' / ' . $data->no_formulir;
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'No. Registrasi Donor Darah',
            'value' => function($data) {
                $cekPendonor = PendonorM::model()->findByAttributes(array('pendonor_id' => $data->pendonor_id));
                echo $cekPendonor->no_pendonor;
            },
        ),
        array(
            'header' => 'Nomor Identitas Donor',
            'name' => 'no_identitas',
            'value' => function($data) {
                $cekPendonor = PendonorM::model()->findByAttributes(array('pendonor_id' => $data->pendonor_id));
                echo $cekPendonor->no_identitas;
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Nama Donor',
            'name' => 'nama_lengkap',
            'value' => function($data) {
                $cekPendonor = PendonorM::model()->findByAttributes(array('pendonor_id' => $data->pendonor_id));
                echo $cekPendonor->nama_lengkap;
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Tempat / Tgl Lahir',
            'value' => function($data) {
                $cekPendonor = PendonorM::model()->findByAttributes(array('pendonor_id' => $data->pendonor_id));
                echo $cekPendonor->tempat_lahir . ' / ' . MyFormatter::formatDateTimeForUser($cekPendonor->tgllahir);
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Jenis Kelamin',
            'value' => function($data) {
                $cekPendonor = PendonorM::model()->findByAttributes(array('pendonor_id' => $data->pendonor_id));
                echo $cekPendonor->jenis_kelamin;
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Umur',
            'value' => function($data) {
                $cekPendonor = PendonorM::model()->findByAttributes(array('pendonor_id' => $data->pendonor_id));
                $biday = new DateTime($cekPendonor->tgllahir);
                $today = new DateTime();

                $diff = $today->diff($biday);
                echo $diff->y . ' Tahun';
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Alamat',
            'value' => function($data) {
                $cekPendonor = PendonorM::model()->findByAttributes(array('pendonor_id' => $data->pendonor_id));
                echo $cekPendonor->alamat_lengkap;
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Berat/Tinggi Badan',
            'value' => function($data) {
                echo !empty($data->beratbadan_kg) ? $data->beratbadan_kg. ' kg' : '-' . ' kg';
                echo ' / ';
                echo !empty($data->tinggibadan_cm) ? $data->tinggibadan_cm. ' cm' : '-' . ' cm';
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'ABO',
            'value' => function($data) {
                $cekPendonor = PendonorM::model()->findByAttributes(array('pendonor_id' => $data->pendonor_id));
                echo $cekPendonor->gol_darah;
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Rhesus',
            'value' => function($data) {
                $cekPendonor = PendonorM::model()->findByAttributes(array('pendonor_id' => $data->pendonor_id));
                echo $cekPendonor->rhesus;
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Ruangan Rekrutmen',
            'value' => function($data) {
                if(empty($data->ruangrekrutmen)) {
                    echo $data->lokasi_rekruitmen ?? '';
                } else {
                    echo $data->ruangrekrutmen->ruangan_nama ?? '';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Petugas Daftar',
            'value' => function($data) {
                $nama_petugas = PegawaiM::model()->findByPk($data->nama_petugas_id)->nama_pegawai;
                echo isset($nama_petugas) ? $nama_petugas : "";
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Status Donor',
            'value' => function($data) {
                if ($data->status == 'ANTRIAN') {
                    echo 'ANTRIAN';
                } else if ($data->status == 'SELEKSI') {
                    echo 'SELEKSI';
                } else if ($data->status == 'OBSERVASI') {
                    echo 'OBSERVASI';
                } else if ($data->status == 'SELESAI') {
                    echo 'SELESAI';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Seleksi Donor ',
            'type' => 'raw',
            'value' => '$data->getSeleksi($data->pendonor_id,$data->daftardonasi_id,$data)',
            'htmlOptions' => array('style' => 'text-align:center;'),
        ),
        array(
            'header' => 'Observasi Donor Darah',
            'type' => 'raw',
            'value' => '$data->getObservasi($data->pendonor_id,$data->daftardonasi_id,$data)',
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Kantong Darah',
            'value' => '$data->getKantong($data->pendonor_id,$data->daftardonasi_id,$data)',
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Batal Donor',
            'type' => 'raw',
            'value' => function($data) {
                $modNyeri = PeriksanyeripendonorT::model()->findByAttributes(array('daftardonasi_id' => $data->daftardonasi_id));
                $modObservasi = ObservasipendonorT::model()->findByAttributes(array('daftardonasi_id' => $data->daftardonasi_id));
                if (empty($modNyeri) || empty($modObservasi)) {
                    return CHtml::link("<span style='font-size:15px;'><i class='entypo-cancel'></i></span>", '', array(
                                'class' => 'hover',
                                "rel" => "tooltip",
                                'data-placement' => 'left',
                                'onclick' => 'Bataldonordarah(' . $data->daftardonasi_id . ');return false;',
                                "title" => "Klik untuk Batal Donor Darah"));
                } else {
                    return CHtml::link("<span style='font-size:15px;'><i class='entypo-cancel'></i></span>", '', array(
                                'class' => 'hover',
                                "rel" => "tooltip",
                                'data-placement' => 'left',
                                'onclick' => 'myAlert("Observasi Donor telah dilakukan. Batal donor tidak dapat dilakukan");return false;',
                                "title" => "Klik untuk Batal Donor Darah"));
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align:center'
            ),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>