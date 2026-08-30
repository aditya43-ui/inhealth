<?php
$this->breadcrumbs = array(
    'Informasi Manpower',
); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Manpower</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        // load data
        $prov = $model->searchPegawaiBulan();
        $data_kelamin = array();
        $data_pegawai = array(
            'Jumlah Pegawai Aktif' => 0,
            'Jumlah Pegawai Resign' => 0
        );
        $data_jabatan = array();
        $data_agama = array();
        $data_kategori = array();
        $data_pendidikan = array();
        $data_ptkp = array();
        $data_masa = array(
            '< 2 Tahun' => 0,
            '2 - 5 Tahun' => 0,
            '6 - 10 Tahun' => 0,
            '> 10 Tahun' => 0,
        );
        foreach ($prov->data as $item) {
            // kelamin
            $kelamin = strtoupper($item->jeniskelamin);
            if (empty($data_kelamin[$kelamin])) {
                $data_kelamin[$kelamin] = 0;
            }
            $data_kelamin[$kelamin]++;
            // jabatan
            $jabatan = "Tidak Ada";
            if (!empty($item->jabatan_id)) {
                $modJabatan = JabatanM::model()->findByPk($item->jabatan_id);
                if (!empty($modJabatan)) {
                    $jabatan = $modJabatan->jabatan_nama;
                }
            }
            if (empty($data_jabatan[$jabatan])) {
                $data_jabatan[$jabatan] = 0;
            }
            $data_jabatan[$jabatan]++;
            // agama
            $agama = strtoupper($item->agama);
            if (empty($data_agama[$agama])) {
                $data_agama[$agama] = 0;
            }
            $data_agama[$agama]++;
            // pendidikan
            $pendidikan = "Tidak ada";
            if (!empty($item->pendidikan_id)) {
                $mod_pendidikan = PendidikanM::model()->findByPk($item->pendidikan_id);
                if (!empty($mod_pendidikan)) {
                    $pendidikan = $mod_pendidikan->pendidikan_nama;
                }
            }
            if (empty($data_pendidikan[$pendidikan])) {
                $data_pendidikan[$pendidikan] = 0;
            }
            $data_pendidikan[$pendidikan]++;
            // status
            if (!empty($item->ptkp_id)) {
                $ptkp = PtkpM::model()->findByPk($item->ptkp_id);
                $ptkp_kode = $ptkp->kodeptkp . "/" . $ptkp->jmltanggunan;
                if (empty($data_ptkp[$ptkp_kode])) {
                    $data_ptkp[$ptkp_kode] = 0;
                }
                $data_ptkp[$ptkp_kode]++;
            }
            // kategori
            if (empty($data_kategori[$item->kategoripegawai])) {
                $data_kategori[$item->kategoripegawai] = 0;
            }
            $data_kategori[$item->kategoripegawai]++;
            // masa kerja
            $date1 = new DateTime($item->tgl_start);
            $date2 = new DateTime($item->tgl_sekarang);
            $interval = $date1->diff($date2);
            if ($interval->y < 2) {
                $data_masa['< 2 Tahun']++;
            } else if ($interval->y < 6) {
                $data_masa['2 - 5 Tahun']++;
            } else if ($interval->y < 11) {
                $data_masa['6 - 10 Tahun']++;
            } else {
                $data_masa['> 10 Tahun']++;
            }
            // pegawai
            $pegawai = strtoupper($item->pegawai_aktif);
            // if (empty($data_pegawai[$pegawai])) {
            //     $data_pegawai[$pegawai] = 0;
            // }
            if ($pegawai == true) {
                $data_pegawai['Jumlah Pegawai Aktif']++;
            } else {
                $data_pegawai['Jumlah Pegawai Resign']++;
            }
        }
        // pencarian
        echo $this->renderPartial('_search', array(
            'model' => $model,
        ), true);
        echo $this->renderPartial('_chart', array(
            'model' => $model,
            'data_kelamin' => $data_kelamin,
            'data_jabatan' => $data_jabatan,
            'data_agama' => $data_agama,
            'data_kategori' => $data_kategori,
            'data_pendidikan' => $data_pendidikan,
            'data_masa' => $data_masa,
            'data_ptkp' => $data_ptkp,
            'data_pegawai' => $data_pegawai,
        ), true);
        ?>
    </div>
</div>