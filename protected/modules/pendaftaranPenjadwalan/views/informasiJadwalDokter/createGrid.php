<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Penjadwalan Dokter IGD</b>
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
                                $jadwal = JadwaldokterM::model()->findAll('(jadwaldokter_tgl between ? and ?) and instalasi_id =?', array($tahun . '-' . $bulan . '-' . $jumlah, $tahun . '-' . $bulan . '-' . $jumlah, Params::INSTALASI_ID_RD));
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
                                    $ruangan[$row->ruangan->ruangan_nama][$counter]['instalasi_nama'] = $row->instalasi->instalasi_nama;
                                    $ruangan[$row->ruangan->ruangan_nama][$counter]['nama_pegawai'] = $row->pegawai->nama_pegawai;
                                    $ruangan[$row->ruangan->ruangan_nama]['active'] = ($row->ruangan_id == $ru) ? 'active' : '';
                                }

                                foreach ($ruangan as $counter => $row) {
                                    echo '<div class="box1 ' . $row['active'] . '">' . $counter . '<ul>';
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
                } ?>
            </tbody>
        </table>
    </div>
</div>