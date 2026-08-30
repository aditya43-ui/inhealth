<?php

// dikarenakan data-nya banyak maka dilepasin timeout maksimal eksekusi berjalan
ini_set('max_execution_time', '0');

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
$j = JabatanM::model()->findByPk(Params::JABATAN_ID_KASI_PERSONALIA);

$jabAkses = array(
    'jabatan_id' => Yii::app()->user->getState('jabatan_id'),
    'jabatan_nama' => (!empty($j)) ? $j->jabatan_nama : null,
);
?>
<?php

$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
    'id' => 'laporanpresensi-t-grid',
    'dataProvider' => $model->searchInfoTablePrint(),
    'template' => "{items}",
    'itemsCssClass' => 'table border',
    'mergeHeaders' => array(
        array(
            'name' => '<p style="margin: 0; text-align: center;">Jam</p>',
            'start' => '7',
            'end' => '10',
        ),
    ),
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
        ),
        array(
            'header' => 'No. FP',
            'name' => 'no_fingerprint'
        ),
        array(
            'header' => 'Kelompok Pegawai/<br> Jabatan',
            'type' => 'raw',
            'value' => function($data) {
                return $data["kelompokpegawai_nama"] . '/<br>' . $data["jabatan_nama"];
            }
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai'
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai'
        ),
        array(
            'header' => 'Shift Kerja',
            'type' => 'raw',
            'value' => function($data) {
                if (!empty($data['shift_id'])) {
                    return $data['shift_nama'] . '/<br>' . $data['shift_jamawal'] . '-' . $data['shift_jamakhir'];
                }
            }
        ),
        array(
            'header' => 'Tgl. Presensi',
            'value' => function($data) {
                return MyFormatter::formatDateTimeForUser($data['tglpresensi']);
            }
        ),
        array(
            'header' => 'Masuk',
            'value' => '$data["jamscan_masuk"]'
        ),
        array(
            'header' => 'Keluar',
            'value' => '$data["jamscan_keluar"]'
        ),
        array(
            'header' => 'Datang',
            'value' => '$data["jamscan_datang"]'
        ),
        array(
            'header' => 'Pulang',
            'value' => '$data["jamscan_pulang"]'
        ),
        array(
            'header' => 'Terlambat',
            'value' => function($data) {
                if (!empty($data['terlambat_mnt']) || $data['terlambat_mnt'] > 0) {
                    return $data['terlambat_mnt'] . 'm';
                }
                /* if ($data['verifikasi'] != true){
                  if (!empty($data['shift_id']) && !empty($data['jamscan_masuk'])){
                  if ($data['shift_jamawal'] < $data['shift_jamakhir']){
                  if ($data['verifikasi'] != true){
                  $shiftawal = date('Y-m-d', strtotime($data['tglpresensi'])).' '.$data['shift_jamawal'];
                  $shiftawal = strtotime(date('Y-m-d H:i:s', strtotime($shiftawal.' '.Params::PRESENSI_AWAL_TERLAMBAT)));

                  $scantawal = strtotime(date('Y-m-d', strtotime($data['tglpresensi'])).' '.$data['jamscan_masuk']);
                  }else{
                  //$shiftawal = strtotime(date('Y-m-d', strtotime($data['tglpresensi'])).' '.$data['jamkerjamasuk']);
                  $shiftawal = date('Y-m-d', strtotime($data['tglpresensi'])).' '.$data['jamkerjamasuk'];
                  $shiftawal = strtotime(date('Y-m-d H:i:s', strtotime($shiftawal.' '.Params::PRESENSI_AWAL_TERLAMBAT)));

                  $scantawal = strtotime(date('Y-m-d', strtotime($data['tglpresensi'])).' '.$data['jamscan_masuk']);
                  }

                  $jam = round(round(abs($shiftawal - $scantawal ) / 60,2));

                  if ($data['jamscan_masuk'] > $data['shift_jamawal']){
                  if ($jam > 0){
                  return $jam.' m';
                  }
                  }
                  }
                  }
                  }else{
                  return $data['terlambat_mnt'].' m';
                  } */
            },
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Pulang Awal',
            'value' => function($data) {
                if (!empty($data['pulangawal_mnt']) || $data['pulangawal_mnt'] > 0) {
                    return $data['pulangawal_mnt'] . 'm';
                }
                /* if ($data['verifikasi'] != true){
                  if (!empty($data['shift_id'] && !empty($data['jamscan_pulang']))){
                  if ($data['shift_jamawal'] < $data['shift_jamakhir']){
                  if ($data['verifikasi'] != true){
                  $shiftakhir = strtotime(date('Y-m-d').' '.$data['shift_jamakhir']);
                  $scantakhir = strtotime(date('Y-m-d').' '.$data['jamscan_pulang']);
                  }else{
                  $shiftakhir = strtotime(date('Y-m-d').' '.$data['jamkerjapulang']);
                  $scantakhir = strtotime(date('Y-m-d').' '.$data['jamscan_pulang']);
                  }

                  $jam = round(round(abs($scantakhir - $shiftakhir) / 60,2));

                  if ($data['jamscan_pulang'] < $data['shift_jamakhir']){
                  if ($jam > 0){
                  return $jam.' m';
                  }
                  }
                  }
                  }
                  }else{
                  return $data['pulangawal_mnt'].' m';
                  } */
            },
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Status Kehadiran',
            'type' => 'raw',
            'value' => function($data) use ($jabAkses) {
                $data['jabatanuser_id'] = $jabAkses['jabatan_id'];
                $data['jabatanuser_nama'] = $jabAkses['jabatan_nama'];

                if ($data['verifikasi'] != true) {
                    if (!empty($data['jamscan_masuk'])) {
                        if (!empty($data['shift_id'])) {
                            if ($data['verifikasi'] == true) {
                                $jamkerja = date("H:i:s", strtotime($data['jamkerjamasuk'] . ' +1 hours'));
                            } else {
                                $jamkerja = date("H:i:s", strtotime($data['shift_jamawal'] . ' +1 hours'));
                            }

                            if ($data['jamscan_masuk'] < $jamkerja) {
                                return Params::getWarnaKehadiran(Params::STATUSKEHADIRAN_NAMA_HADIR, true, $data);
                            }

                            //var_dump($data['jamscan_masuk']);
                            //var_dump($jamkerja);

                            if ($data['jamscan_masuk'] > $jamkerja) {
                                return Params::getWarnaKehadiran(Params::STATUSKEHADIRAN_NAMA_ALPHA, true, $data);
                            }
                        } else {
                            return Params::getWarnaKehadiran(Params::STATUSKEHADIRAN_NAMA_HADIR, true, $data);
                        }
                    }

                    if (!empty($data['jamscan_pulang'])) {
                        return Params::getWarnaKehadiran(Params::STATUSKEHADIRAN_NAMA_ALPHA, true, $data);
                    }

                    return Params::getWarnaKehadiran(Params::STATUSKEHADIRAN_NAMA_ALPHA, true, $data);
                } else {
                    return Params::getWarnaKehadiran($data['statuskehadiran_nama'], true, $data);
                }
            },
        ),
        array(
            'header' => 'Keterangan',
            'type' => 'raw',
            'value' => function($data) {
                if ($data['keterangan'] != '') {
                    return $data['keterangan'];
                }

                if (!empty($data['shift_id'])) {
                    $pesan = 'Tidak ada';
                    if (empty($data['jamscan_masuk'])) {
                        $pesan .= ' jam masuk ';
                    }

                    if (empty($data['jamscan_pulang'])) {
                        if ($pesan == 'Tidak ada') {
                            if ($data['tglpresensi'] . ' ' . $data['shift_jamakhir'] <= date('Y-m-d H:i:s')) {
                                $pesan .= ' jam pulang ';
                            }
                        } else {
                            if ($data['tglpresensi'] . ' ' . $data['shift_jamakhir'] <= date('Y-m-d H:i:s')) {
                                $pesan .= ' dan jam pulang ';
                            }
                        }
                    }

                    if ($pesan != 'Tidak ada') {
                        return "<span style='color:#aa0808'>" . $pesan . "</span>";
                    }
                } else {
                    return "<span style='color:#aa0808'>Shift belum di set</span>";
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>