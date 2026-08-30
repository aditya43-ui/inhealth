<style>
    .button-all {
        float: right;
        color: black;
        margin-right: 100px;
        margin-top: 10px;
    }
</style>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Penjadwalan Dokter Poliklinik</b>
        </div>
        <div class="button-all">
            <button onclick="getjadwaldokter()"><i class='icon-kirimdok'></i> Sinkron Semua Jadwal Dokter</button>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table class="table table-striped table-bordered table-condensed" border="1">
            <thead>
                <tr>
                    <?php
                    foreach (CustomFunction::getNamaHari() as $key => $value) {
                        echo '<th>' . $value . '</th>';
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $jumlah = 1;
                for ($x = 1; $x <= ceil($jumlahHari / count(CustomFunction::getNamaHari())); $x++) {
                    echo '<tr>';
                    foreach (CustomFunction::getNamaHari() as $key => $value) {
                        $tgl = Yii::app()->dateFormatter->formatDateTime(strtotime($tahun . '-' . $bulan . '-' . $jumlah), 'full', null);
                        $tanggal = explode(',', $tgl);
                        if ($jumlah > $jumlahHari) {
                            echo '<td class="disabled"></td>';
                        } else {
                            if (strtolower(trim($value)) == strtolower(trim($tanggal[0]))) {
                                $cr = new CDbCriteria;
                                $cr->addCondition("jadwaldokter_tgl::date between :tgl_awal and :tgl_akhir");
                                $cr->params = array(
                                    ':tgl_awal' => $tahun . '-' . $bulan . '-' . $jumlah,
                                    ':tgl_akhir' => $tahun . '-' . $bulan . '-' . $jumlah,
                                );
                                $cr->compare('instalasi_id', Params::INSTALASI_ID_RJ);
                                if (isset($variable['pegawai_id']) && count((array)$variable['pegawai_id']) > 0) {
                                    $cr->compare('pegawai_id', $variable['pegawai_id']);
                                }
                                if (isset($variable['ruangan_id']) && count((array)$variable['ruangan_id']) > 0) {
                                    $cr->compare('ruangan_id', $variable['ruangan_id']);
                                }

                                $jadwal = JadwaldokterM::model()->findAll($cr);
                                echo '<td>' . $tgl;
                                $ruangan = array();

                                foreach ($jadwal as $counter => $row) {
                                    $ru = null;
                                    if (isset($variable['ruangan_id'])) {
                                        foreach ($variable['ruangan_id'] as $r) {
                                            if ($row->ruangan_id == $r) {
                                                $ru = $r;
                                            }
                                        }
                                    }
                                    $ruangan[$row->ruangan->ruangan_nama][$counter] = $row->attributes;
                                    $ruangan[$row->ruangan->ruangan_nama]['ruangan_id'] = $row->ruangan_id;
                                    $ruangan[$row->ruangan->ruangan_nama]['jadwaldokter_tgl'] = $row->jadwaldokter_tgl;
                                    $ruangan[$row->ruangan->ruangan_nama][$counter]['instalasi_nama'] = $row->instalasi->instalasi_nama;
                                    $ruangan[$row->ruangan->ruangan_nama][$counter]['nama_pegawai'] = empty($row->pegawai) ? "-" : $row->pegawai->namaLengkap;
                                    $ruangan[$row->ruangan->ruangan_nama]['active'] = ($row->ruangan_id == $ru) ? 'active' : '';
                                }
                                foreach ($ruangan as $counter => $row) {

                                    $tombolscy = "";
                                    $tombolscy = CHtml::Link(
                                        "<i class='icon-kirimdok'></i>",
                                        'javascript:void(0);',
                                        array(
                                            "class" => "",
                                            "onclick" => "getSyncJadwalDokter('" . $row['ruangan_id'] . "','" . $row['jadwaldokter_tgl'] . "')",
                                            "rel" => "tooltip",
                                            "title" => "Klik Untuk Sinkronisasi Jadwal Dokter dari BPJS",
                                        )
                                    );
                                    echo '<div class="box1 ' . $row['active'] . '">' . $counter . ' ' . $tombolscy . '<ul>';
                                    foreach ($row as $counterDokter => $dokter) {
                                        if (is_integer($counterDokter)) {
                                            $peg_dok = null;
                                            if (isset($variable['pegawai_id'])) {
                                                foreach ($variable['pegawai_id'] as $dok) {
                                                    if ($dokter['pegawai_id'] == $dok) {
                                                        $peg_dok = $dok;
                                                    }
                                                }
                                            }

                                            //var_dump($variable);
                                            echo '<li class="pegawai_id_' . $dokter['pegawai_id'] . ' ' . ((($dokter['pegawai_id'] == $peg_dok) ? 'active' : '')) . '">
                                                <a href="" onclick="updateJadwal(' . $dokter['jadwaldokter_id'] . '); return false;">' . $dokter['nama_pegawai'] . ' (' . substr($dokter['jadwaldokter_mulai'], 0, 2) . ' - ' . substr($dokter['jadwaldokter_tutup'], 0, 2) . ')</a>
                                                    </li>';
                                        }
                                    }
                                    echo '</ul></div>';
                                }
                                echo '</td>';
                                $jumlah++;
                            } else {
                                echo '<td class="disabled"></td>';
                            }
                        }
                    }
                    if ($x == ($jumlahHari / count(CustomFunction::getNamaHari()))) {
                        if ($jumlah <= $jumlahHari) {
                            $x--;
                        }
                    }
                    echo '</tr>';
                }
                ?>

            </tbody>
        </table>
    </div>
</div>

<script>
    function getjadwaldokter() {
        var jadwal = $('#PPJadwaldokterM_jadwaldokter_mulai').val()
        var ruangan_id = JSON.parse(<?php echo json_encode(isset($_GET['PPJadwaldokterM']['ruangan_id']) ? $_GET['PPJadwaldokterM']['ruangan_id'] : ""); ?>)
        $.ajax({
            url: '<?php echo $this->createUrl('/pendaftaranPenjadwalan/InfoDokterPoliKlinik/GetAllJadwalDokter'); ?>',
            type: "post",
            dataType: "json",
            data: {
                jadwal: jadwal,
                ruangan_id: ruangan_id
            },
            success: function(data) {
                if (data != '') {
                    myAlert(data.msg);
                    if (data.sukses == 1) {
                        window.location = window.location.href;
                    }
                }
                console.log('berhasilcuyy', data)
            }
        });
    }
</script>