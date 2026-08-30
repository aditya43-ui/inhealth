<style>
    .judul {
        text-align: center;

    }

    table.table-2 {
        border: 1px solid;
    }

    td.table-2 {
        border: 1px solid;
    }

    th.table-2 {
        border: 1px solid;
    }

    table.table-2 {
        width: 80%;
        border-collapse: collapse;
    }

    .content-bawah {
        font-size: 10px !important;
    }

    .corner-word {
        position: absolute;
        top: 0;
        right: 0;
    }
</style>

<div class="corner-word">
    <h3><?php echo $modDaftar->carabayar->carabayar_namalainnya; ?></h3>
</div>
<div class="content-rm">
    <div class="judul">
        <h3>FORMULIR VERIFIKASI <br> SISTEM CASE-MIX / INA-CBG</h3>
    </div>

    <div class="form-tabel">
        <table width='100%'>
            <tr>
                <td width='5%'>1. </td>
                <td width='25%'>Nama RS</td>
                <td width='2%'>:</td>
                <td colspan="7"><?php echo $modProfil->nama_rumahsakit; ?></td>
            </tr>
            <tr>
                <td>2. </td>
                <td>Nomor Kode RS</td>
                <td>:</td>
                <td><?php echo $modProfil->nokode_rumahsakit; ?></td>
                <td width='20%'></td>
                <td width='3%'>3. </td>
                <td width='10%'>Kelas RS</td>
                <td width='1%'>:</td>
                <td width='10%'><?php echo $modProfil->kelas_rumahsakit; ?></td>
                <td></td>
            </tr>
            <tr>
                <td>4. </td>
                <td>Nomor Rekam Medik</td>
                <td>:</td>
                <td><?php echo $modPasien->no_rekam_medik ?></td>
            </tr>
            <tr>
                <td>5. </td>
                <td>Nama Pasien</td>
                <td>:</td>
                <td colspan="2"><?php echo $modPasien->nama_pasien ?></td>
            </tr>
            <tr>
                <td>6. </td>
                <td>Jenis Perawatan</td>
                <td>:</td>
                <td colspan="2"><?php
                                $instalasi = explode(" ", $modDaftar->instalasi->instalasi_nama);
                                if (!empty($modDaftar->pasienadmisi_id)) {
                                    echo "RAWAT INAP";
                                } else {
                                    echo  $instalasi[1] . " " . $instalasi[2];
                                }

                                ?></td>
            </tr>
            <tr>
                <td>7. </td>
                <td>Kelas Perawatan</td>
                <td>:</td>
                <td colspan="2"><?php
                                if (!empty($modDaftar->pasienadmisi_id)) {
                                    echo $modDaftar->pasienadmisi->kelaspelayanan->kelaspelayanan_nama;
                                } else {
                                    echo $modDaftar->kelaspelayanan->kelaspelayanan_nama;
                                }

                                ?></td>

            </tr>
            <tr>
                <td>8. </td>
                <td>Total Biaya</td>
                <td>:</td>
                <td></td>
            </tr>
            <tr>
                <td>9. </td>
                <td>Tanggal Masuk</td>
                <td>:</td>
                <td> <?php
                        if (!empty($modDaftar->pasienadmisi_id)) {
                            echo MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($modDaftar->pasienadmisi->tgladmisi)));
                        } else {
                            echo MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($modDaftar->tgl_pendaftaran)));
                        }
                        ?></td>
                <td width="300px"> 10.Tanggal Keluar</td>
                <td>:</td>
                <td></td>
            </tr>
            <tr>
                <td>11. </td>
                <td>Jumlah Hari Perawatan</td>
                <td>:</td>
                <td></td>
                <td colspan="4">Tgl.Keluar - Tgl.Masuk + 1</td>
            </tr>
            <tr>
                <td>12. </td>
                <td>Tanggal Lahir</td>
                <td>:</td>
                <td><?php echo MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir) ?></td>
                <td>13. Usia Dalam Tahun </td>
                <td>:</td>
                <td><?php echo CustomFunction::getUmurTahun($modPasien->tanggal_lahir, date('Y-m-d')) . " tahun"; ?></td>
                <td colspan="3">14. Usia Dalam Hari : <?php echo CustomFunction::getUmur($modPasien->tanggal_lahir); ?></td>
            </tr>
            <tr>
                <td>15. </td>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td colspan="2"><?php echo $modPasien->jeniskelamin; ?></td>
            </tr>
            <tr>
                <td>16. </td>
                <td>Cara Pulang</td>
                <td>:</td>
                <td></td>
                <td colspan="6">
                    <?php
                    $modCaraKeluar = CarakeluarM::model()->findAllByAttributes(array('carakeluar_aktif' => True));
                    // foreach($modCaraKeluar as $carakeluar){
                    //     echo $carakeluar->carakeluar_nama;
                    // }
                    echo "a. " . strtolower($modCaraKeluar[0]->carakeluar_nama) . "  b. " .  strtolower($modCaraKeluar[1]->carakeluar_nama) . "  c. " .  strtolower($modCaraKeluar[2]->carakeluar_nama) . " d. " .  strtolower($modCaraKeluar[3]->carakeluar_nama) . " e. " .  strtolower($modCaraKeluar[4]->carakeluar_nama) . " f. " .  strtolower($modCaraKeluar[5]->carakeluar_nama);
                    ?></td>

            </tr>
            <tr>
                <td>17. </td>
                <td>Berat Lahir</td>
                <td>:</td>
                <td></td>
            </tr>
            <tr>
                <td>18. </td>
                <td>Diagnosa Utama</td>
                <td>:</td>
                <td style="border: 1px solid black;" colspan="2"></td>
                <td></td>
                <td style="border: 1px solid black;" colspan="4">ICD-10: </td>
            </tr>
            <tr>
                <td>19. </td>
                <td>Diagnosa Sekuder</td>
                <td>:</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="9">
                    <table width='100%' class="table-2">
                        <thead>
                            <tr>
                                <th class="table-2">No</th>
                                <th class="table-2">DIAGNOSA</th>
                                <th class="table-2">ICD-10</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 0; $i <= 9; $i++) { ?>
                                <tr>
                                    <td class="table-2"><?php echo $i + 1 ?></td>
                                    <td class="table-2"></td>
                                    <td class="table-2"></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td>20. </td>
                <td>Prosedur/ Tindakan</td>
                <td>:</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="9">
                    <table width='100%' class="table-2">
                        <thead>
                            <tr>
                                <th class="table-2">No</th>
                                <th class="table-2">TINDAKAN / PROSEDUR</th>
                                <th class="table-2">ICD-9-CM</th>
                                <th class="table-2">TGL TINDAKAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 0; $i <= 9; $i++) { ?>
                                <tr>
                                    <td class="table-2"><?php echo $i + 1 ?></td>
                                    <td class="table-2"></td>
                                    <td class="table-2"></td>
                                    <td class="table-2"></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div class="content-bawah">
        <table>
            <tr>
                <td>Catatan:</td>
                <td>Diagnosis diisi oleh dokter yang merawat / yang memeriksa dengan huruf "Cetak"<br></td>
            </tr>
            <tr>
                <td></td>
                <td>Untuk Pasien yang dilakukan tindakan, disertakan "tanggal" dilakukannya tindakan tersebut.</td>
            </tr>
        </table>
    </div>
    <div class="ttd">
        <table width='100%'>
            <tr>
                <td></td>
                <td align='center'>
                    <?php echo Yii::app()->user->getState('kabupaten_nama') . ", " . $format->formatDateTimeId(date('Y-m-d')); ?>
                </td>
            </tr>
            <tr>
                <td align='center'>DPJP / Dokter yang merawat</td>
                <td align='center'>Pasien/Keluarga Pasien</td>
                </td>
            </tr>
            <tr></tr>
            <tr></tr>
            <tr></tr>
            <tr></tr>
            <tr></tr>
            <tr height='150px'>
                <td align='center'><?php echo $modDaftar->pegawai->namaLengkap ?><br>NIP.<?php echo $modDaftar->pegawai->nomorindukpegawai; ?></td>
                <td align='center'>(.........................................)</td>
            </tr>
        </table>
    </div>
</div>