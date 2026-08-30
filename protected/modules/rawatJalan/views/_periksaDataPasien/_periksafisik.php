<?php
if (isset($caraPrint)) {
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
    }
    echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan));
} 
?>
<style>
    .barcode-label {
        margin-top: -20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }

    td,
    th {
        font-size: 8pt !important;
        height: 24px;
        padding-left: 10px;
        vertical-align: top;
    }

    body {
        width: 14.7cm;
    }

    .content td {
        /*height: 48px;*/
    }

    #tab_norton td,
    #tab_norton th {
        border: 1px solid black;
        padding: 2px;
    }

    #tab_norton th {
        font-weight: bold;
        text-align: center;
    }

    #tab_norton .skor,
    #tab_norton .total_skor {
        text-align: right;
    }
</style>
<table width="60%" border="1">
    <tr>
        <td style="width:15%">Nama Pasien / No. RM</td>
        <td style="width:15%">: <?php echo $modPasien->nama_pasien; ?> / <?php echo $modPasien->no_rekam_medik; ?></td>
        <td style="width:15%">No. Pendaftaran</td>
        <td style="width:15%">: <?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
</table>
<!--<table width="100%" class="content" style="border: none;">-->
<?php
if (count((array)$modPemeriksaanFisik) > 0) {
    foreach ($modPemeriksaanFisik as $i => $loop) {
?>
        <div style="text-align:center;vertical-align:middle;font-weight:bold;">
            PERIKSA FISIK
        </div>
        <div class="row" style="border-top: 2px solid black;">
            <div class="col-sm-6">
                <table>
                    <tr>
                        <td style="width:20%">Nama Dokter</td>
                        <td style="width:25%">: <?php echo (isset($loop->pegawai_id) ? $loop->pegawai->nama_pegawai : "-"); ?></td>
                    </tr>
                    <tr>
                        <td style="width:20%">Paramedis</td>
                        <td style="width:25%">: <?php echo (isset($loop->paramedis_nama) ? $loop->paramedis_nama : "-"); ?></td>
                    </tr>
                    <tr>
                        <td style="width:20%">Keadaan</td>
                        <td style="width:25%">: <?php echo (isset($loop->keadaanumum) ? $loop->keadaanumum : "-"); ?></td>
                    </tr>
                    <tr>                   
                    <tr>
                        <td width="15%">Detak Nadi</td>
                        <td width="30%">: <?php echo (isset($loop->detaknadi) ? $loop->detaknadi : " - ") . ' /Menit'; ?></td>
                    </tr>
                    <tr>
                        <td width="15%">Denyut Jantung</td>
                        <td width="30%">: <?php echo (isset($loop->denyutjantung) ? $loop->denyutjantung : " - "); ?></td>
                    </tr>
                    <tr>
                        <td width="15%">Tekanan Darah</td>
                        <td width="30%">: <?php echo (isset($loop->tekanandarah) ? $loop->tekanandarah : " - ") . ' /MmHg'; ?></td>
                    </tr>
                    <tr>
                        <td width="15%">Mean Arterial Pressure</td>
                        <td width="30%">: <?php echo isset($loop->meanarteripressure) ? $loop->meanarteripressure : " - "; ?></td>
                    </tr>
                    <tr>
                        <td width="15%">Suhu Tubuh</td>
                        <td width="30%">: <?php echo (isset($loop->suhutubuh) ? $loop->suhutubuh : " - ") . ' &deg; Celcius'; ?></td>
                    </tr>
                    <?php /*
                      <tr>
                      <td width="15%">Perkusi</td>
                      <td width="30%">: <?php echo isset($loop->perkusi)?$loop->perkusi:" - "; ?></td>
                      </tr>
                     * 
                     */ ?>
                    <tr>
                        <td width="15%">Tinggi badan / Berat badan</td>
                        <td width="30%">: <?php echo (isset($loop->tinggibadan_cm) ? $loop->tinggibadan_cm : " - ") . ' Cm / ' . (isset($loop->beratbadan_kg) ? $loop->beratbadan_kg : " - ") . ' Kg'; ?></td>
                    </tr>
                    <?php
                    $bmi_definisi = "-";
                    $bmi = "-";
                    if (!empty($loop->tinggibadan_cm) && !empty($loop->beratbadan_kg) && is_numeric($loop->tinggibadan_cm) && is_numeric($loop->beratbadan_kg) && $loop->tinggibadan_cm != 0) {
                        $bmi = floor((float)$loop->beratbadan_kg / ((float)$loop->tinggibadan_cm * (float)$loop->tinggibadan_cm / 10000));
                        $criteria2 = new CDbCriteria();
                        $criteria2->select = 'max(bmi_minimum) as max_bmi';
                        $modBMI = BodymassindexM::model()->find($criteria2);
                        $criteria = new CDbCriteria();
                        $criteria->addCondition($bmi . ' >= bmi_minimum');
                        $criteria->addCondition($bmi . ' <= bmi_maksimum');
                        $data = array();
                        $bmi_hasil = BodymassindexM::model()->find($criteria);
                        $bmi_definisi = (!empty($bmi_hasil->bmi_defenisi) ? $bmi_hasil->bmi_defenisi : "");
                    }
                    ?>
                    <tr>
                        <td width="15%">Index Masa Tubuh</td>
                        <td width="30%">: <?php echo $bmi . " - " . $bmi_definisi; ?></td>
                    </tr>
                    <tr>
                        <td width="15%">Pernapasan</td>
                        <td width="30%">: <?php echo (isset($loop->pernapasan) ? $loop->pernapasan : " - ") . ' /Menit'; ?></td>
                    </tr>
                    <tr>
                        <td width="15%">Kelainan Pada Bagian Tubuh</td>
                        <td width="30%">: <?php echo isset($loop->kelainanpadabagtubuh) ? $loop->kelainanpadabagtubuh : " - "; ?></td>
                    </tr>
                    <tr>
                        <td width="15%">Reflek Cahaya</td>
                        <td width="30%">: <?php echo isset($loop->tandavital_reflekcahaya) ? $loop->tandavital_reflekcahaya : " - "; ?></td>
                    </tr>
                    <tr>
                        <td width="15%">SpO2</td>
                        <td width="30%">: <?php echo isset($loop->tandavital_spo2) ? $loop->tandavital_spo2 : " - "; ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-6">
                <table>
                    <tr>
                        <td style="width:20%">Tanggal Periksa</td>
                        <td style="width:30%">: <?php echo (isset($loop->tglperiksafisik) ? MyFormatter::formatDateTimeForUser($loop->tglperiksafisik) : "-"); ?></td>
                    </tr>
                    <tr>
                        <td style="width:20%">Instalasi / Ruangan</td>
                        <td style="width:30%">: <?php
                                                $ruangan = RuanganM::model()->findByPk($loop->create_ruangan);
                                                $instalasi_id = null;
                                                if (empty($ruangan)) {
                                                    echo "-";
                                                } else {
                                                    $instalasi_id = $ruangan->instalasi_id;
                                                    echo $ruangan->instalasi->instalasi_nama . " - " . $ruangan->ruangan_nama;
                                                }
                                                ?></td>
                    </tr>
                </table>
                <table border="1" width="100%">
                    <tr>
                        <td colspan="3"><b>PEMERIKSAAN ANGGOTA TUBUH</b></td>
                    </tr>
                    <?php
                    $modPemeriksaanGambar = PemeriksaangambarT::model()->findAllByAttributes(array(
                        'pemeriksaanfisik_id' => $loop->pemeriksaanfisik_id
                    ));
                    if (count((array)$modPemeriksaanGambar) > 0) {
                    ?>
                        <tr>
                            <td>
                                <p style="margin: 0; text-align: center;"><b>No.</b></p>
                            </td>
                            <td><b>Bagian Tubuh</b></td>
                            <td><b>Keterangan</b></td>
                        </tr>
                        <?php foreach ($modPemeriksaanGambar as $i => $v) {
                        ?>
                            <tr>
                                <td>
                                    <p style="margin: 0; text-align: center;"><?= $i + 1; ?></p>
                                </td>
                                <td><?php echo $v->bagiantubuh->namabagtubuh; ?></td>
                                <td>
                                    <?php echo $v->keterangan_periksa_gbr; ?><br>
                                    <ul>
                                        <li><b>Look : </b><?php echo empty($v->look) ? "-" : $v->look; ?></li>
                                        <li><b>Feel : </b><?php echo empty($v->feel) ? "-" : $v->feel; ?></li>
                                        <li><b>Move : </b><?php echo empty($v->move) ? "-" : $v->move; ?></li>
                                        <li><b>Sensory : </b><?php echo empty($v->sensory) ? "-" : $v->sensory; ?></li>
                                        <li><b>Motorik : </b><?php echo empty($v->motorik) ? "-" : $v->motorik; ?></li>
                                    </ul>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </table>
            </div>
            <div class="span12" style="border-top: 1px solid black;">
                <table id="tblDaftarAnamnesa" width="100%">
                    <?php
                    if ($loop->gcs_jenis == TRUE) {
                        $gcs_eye = RJMetodeGCSM::model()->findByAttributes(array(
                            'metodegcs_nilai' => $loop->gcs_eye,
                        ), array(
                            'condition' => "LOWER(metodegcs_singkatan) = 'be'",
                        ));
                        $gcs_verbal = RJMetodeGCSM::model()->findByAttributes(array(
                            'metodegcs_nilai' => $loop->gcs_verbal,
                        ), array(
                            'condition' => "LOWER(metodegcs_singkatan) = 'bv'",
                        ));
                        $gcs_motorik = RJMetodeGCSM::model()->findByAttributes(array(
                            'metodegcs_nilai' => $loop->gcs_motorik,
                        ), array(
                            'condition' => "LOWER(metodegcs_singkatan) = 'bm'",
                        ));
                    } else {
                        $gcs_eye = RJMetodeGCSM::model()->findByAttributes(array(
                            'metodegcs_nilai' => $loop->gcs_eye,
                        ), array(
                            'condition' => "LOWER(metodegcs_singkatan) = 'e'",
                        ));
                        $gcs_verbal = RJMetodeGCSM::model()->findByAttributes(array(
                            'metodegcs_nilai' => $loop->gcs_verbal,
                        ), array(
                            'condition' => "LOWER(metodegcs_singkatan) = 'v'",
                        ));
                        $gcs_motorik = RJMetodeGCSM::model()->findByAttributes(array(
                            'metodegcs_nilai' => $loop->gcs_motorik,
                        ), array(
                            'condition' => "LOWER(metodegcs_singkatan) = 'm'",
                        ));
                    }
                    
                    $hasil = (empty($loop->gcs_eye) ? 0 : $loop->gcs_eye)
                           + (empty($loop->gcs_verbal) ? 0 : $loop->gcs_verbal)
                           + (empty($loop->gcs_motorik) ? 0 : $loop->gcs_motorik);
                    ?>
                    <tr>
                        <td colspan="4"><b>Glasgow Coma Scale</b></td>
                    </tr>
                    <tr>
                        <td colspan="2" width="30%">GCS Mata (Eye)</td>
                        <td colspan="2" width="70%"><?php echo !empty($gcs_eye) ? $gcs_eye->textMetodeGCSM : " - "; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" width="30%">GCS Verbal</td>
                        <td colspan="2" width="70%"><?php echo !empty($gcs_verbal) ? $gcs_verbal->textMetodeGCSM : " - "; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" width="30%">GCS Motorik</td>
                        <td colspan="2" width="70%"><?php echo !empty($gcs_motorik) ? $gcs_motorik->textMetodeGCSM : " - "; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" width="30%">Hasil</td>
                        <td colspan="2" width="70%"><?php echo isset($hasil) ? $hasil : " - "; ?></td>
                    </tr>
                </table>
            </div>
            <?php if (in_array($instalasi_id, array(Params::INSTALASI_ID_RD, Params::INSTALASI_ID_RI, Params::INSTALASI_ID_PERAWATAN_INTENSIF, Params::INSTALASI_ID_PERSALINAN))) : ?>
                <?php
                echo $this->renderPartial('rawatJalan.views._periksaDataPasien.periksaFisik._kepalaLeher', array(
                    'modPemeriksaanFisik' => $loop
                ), true);
                ?>
            <?php endif; ?>
            <div class="span12" style="border-top: 1px solid black;">
                <table id="tblDaftarAnamnesa" width="100%">
                    <tr>
                        <td colspan="2"><b>Thorax</b></td>
                    </tr>
                    <tr>
                        <td width="30%">Inspeksi</td>
                        <td width="70%"><?php echo isset($loop->inspeksi) ? $loop->inspeksi : " - "; ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Palpasi</td>
                        <td width="70%"><?php echo isset($loop->palpasi) ? $loop->palpasi : " - "; ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Auskultasi</td>
                        <td>
                            <table class="tab_thorax">
                                <tr>
                                    <td width="50"></td>
                                    <td width="60">Kiri</td>
                                    <td width="60">Kanan</td>
                                </tr>
                                <tr>
                                    <td rowspan="3">Rh</td>
                                    <td><?php echo $loop->au_parurhkanan_1; ?></td>
                                    <td><?php echo $loop->au_parurhkiri_1; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $loop->au_parurhkanan_2; ?></td>
                                    <td><?php echo $loop->au_parurhkiri_2; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $loop->au_parurhkanan_3; ?></td>
                                    <td><?php echo $loop->au_parurhkiri_3; ?></td>
                                </tr>
                                <tr>
                                    <td width="50">&nbsp;</td>
                                    <td width="60"></td>
                                    <td width="60"></td>
                                </tr>
                                <tr>
                                    <td rowspan="3">Wh</td>
                                    <td><?php echo $loop->au_paruwhkanan_1; ?></td>
                                    <td><?php echo $loop->au_paruwhkiri_1; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $loop->au_paruwhkanan_2; ?></td>
                                    <td><?php echo $loop->au_paruwhkiri_2; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $loop->au_paruwhkanan_3; ?></td>
                                    <td><?php echo $loop->au_paruwhkiri_3; ?></td>
                                </tr>
                            </table>
                            <table class="tab_thorax">
                                <tr>
                                    <td rowspan="4" width="80">Bunyi<br>Jantung</td>
                                    <td width="30">S1</td>
                                    <td width="60"><?php echo $loop->au_cardios1; ?></td>
                                </tr>
                                <tr>
                                    <td>S2</td>
                                    <td><?php echo $loop->au_cardios2; ?></td>
                                </tr>
                                <tr>
                                    <td>S3</td>
                                    <td><?php echo $loop->au_cardios3; ?></td>
                                </tr>
                                <tr>
                                    <td>S4</td>
                                    <td><?php echo $loop->au_cardios4; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <?php
            if (!empty($loop->reflekbayi)) :
            ?>
                <div class="span12" style="border-top: 1px solid black;">
                    <table id="tblDaftarAnamnesa" width="100%">
                        <?php
                        $loop->reflekbayi = CJSON::decode($loop->reflekbayi);
                        ?>
                        <tr>
                            <td colspan="4"><b>Reflek Bayi</b></td>
                        </tr>
                        <?php foreach ($loop->reflekbayi as $label => $val) : ?>
                            <tr>
                                <td colspan="2" width="30%"><?php echo $label; ?></td>
                                <td colspan="2">
                                    <span class="fa fa<?php echo $val == 'Ya' ? '-check' : '' ?>-square-o"></span> Ya
                                    <span class="fa fa<?php echo $val == 'Tidak' ? '-check' : '' ?>-square-o"></span> Tidak
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php
            endif;
            ?>
            <?php
            $integumen = IntegumenT::model()->findByAttributes(array(
                'pemeriksaanfisik_id' => $loop->pemeriksaanfisik_id,
            ));
            if (!empty($integumen)) :
            ?>
                <div class="span12" style="border-top: 1px solid black;">
                    <table id="tblDaftarAnamnesa">
                        <tr>
                            <td colspan="2"><b>Integumen</b></td>
                        </tr>
                        <tr>
                            <td width="30%">Warna</td>
                            <td><?php echo empty($integumen->warna) ? "-" : $integumen->warna; ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Turgor</td>
                            <td><?php echo empty($integumen->tugor) ? "-" : $integumen->tugor; ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Integritas</td>
                            <td><?php echo empty($integumen->integritas) ? "-" : $integumen->integritas; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div style="font-weight: bold; text-align: center">Skala Norton</div>
                                <table width="100%" id="tab_norton">
                                    <thead>
                                        <tr>
                                            <th>Kategori</th>
                                            <th>4</th>
                                            <th>3</th>
                                            <th>2</th>
                                            <th>1</th>
                                            <th>Skor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Kondisi Fisik</td>
                                            <td><span class="fa fa<?php echo $integumen->norton_kondisifisik == 4 ? '-check' : '' ?>-square-o"></span> Baik</label></td>
                                            <td><span class="fa fa<?php echo $integumen->norton_kondisifisik == 3 ? '-check' : '' ?>-square-o"></span> Sedang</label></td>
                                            <td><span class="fa fa<?php echo $integumen->norton_kondisifisik == 2 ? '-check' : '' ?>-square-o"></span> Buruk</label></td>
                                            <td><span class="fa fa<?php echo $integumen->norton_kondisifisik == 1 ? '-check' : '' ?>-square-o"></span> Sangat Buruk</label></td>
                                            <td style="text-align: right;"><?php echo $integumen->norton_kondisifisik; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Status Mental</td>
                                            <td><span class="fa fa<?php echo $integumen->norton_statusmental == 4 ? '-check' : '' ?>-square-o"></span> Sadar</label></td>
                                            <td><span class="fa fa<?php echo $integumen->norton_statusmental == 3 ? '-check' : '' ?>-square-o"></span> Apatis</label></td>
                                            <td><span class="fa fa<?php echo $integumen->norton_statusmental == 2 ? '-check' : '' ?>-square-o"></span> Bingung</label></td>
                                            <td><span class="fa fa<?php echo $integumen->norton_statusmental == 1 ? '-check' : '' ?>-square-o"></span> Stupor</label></td>
                                            <td style="text-align: right;"><?php echo $integumen->norton_statusmental; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Aktifitas</td>
                                            <td><span class="fa fa<?php echo $integumen->norton_aktifitas == 4 ? '-check' : '' ?>-square-o"></span> Jalan Sendiri</label></td>
                                            <td><span class="fa fa<?php echo $integumen->norton_aktifitas == 3 ? '-check' : '' ?>-square-o"></span> Jalan dengan Bantuan</label></td>
                                            <td><span class="fa fa<?php echo $integumen->norton_aktifitas == 2 ? '-check' : '' ?>-square-o"></span> Kursi Roda</label></td>
                                            <td><span class="fa fa<?php echo $integumen->norton_aktifitas == 1 ? '-check' : '' ?>-square-o"></span> Ditempat Tidur</label></td>
                                            <td style="text-align: right;"><?php echo $integumen->norton_aktifitas; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Mobilitas</td>
                                            <td><span class="fa fa<?php echo $integumen->norton_mobilitas == 4 ? '-check' : '' ?>-square-o"></span> Bebas Bergerak</td>
                                            <td><span class="fa fa<?php echo $integumen->norton_mobilitas == 3 ? '-check' : '' ?>-square-o"></span> Agak Terbatas</td>
                                            <td><span class="fa fa<?php echo $integumen->norton_mobilitas == 2 ? '-check' : '' ?>-square-o"></span> Sangat Terbatas</td>
                                            <td><span class="fa fa<?php echo $integumen->norton_mobilitas == 1 ? '-check' : '' ?>-square-o"></span> Tidak Mampu Bergerak</td>
                                            <td style="text-align: right;"><?php echo $integumen->norton_mobilitas; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Inkontinesia</td>
                                            <td><span class="fa fa<?php echo $integumen->norton_inkontinesia == 4 ? '-check' : '' ?>-square-o"></span> Kontinen</td>
                                            <td><span class="fa fa<?php echo $integumen->norton_inkontinesia == 3 ? '-check' : '' ?>-square-o"></span> Kadang Inkontinensia Uri</td>
                                            <td><span class="fa fa<?php echo $integumen->norton_inkontinesia == 2 ? '-check' : '' ?>-square-o"></span> Selalu Inkontinensia Uri</td>
                                            <td><span class="fa fa<?php echo $integumen->norton_inkontinesia == 1 ? '-check' : '' ?>-square-o"></span> Inkontinensia Uri & Alfi</td>
                                            <td style="text-align: right;"><?php echo $integumen->norton_inkontinesia; ?></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" style="text-align: right;">Total Skor</td>
                                            <td style="text-align: right;"><?php echo $integumen->norton_totalskor; ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">Hasil : <?php
                                                                    if ($integumen->norton_totalskor < 12) {
                                                                        echo "Resiko Tinggi Terjadi Dekubitus";
                                                                    } else if ($integumen->norton_totalskor < 16) {
                                                                        echo "Resiko Sedang (Rentang Terjadi Dekubitus)";
                                                                    } else {
                                                                        echo "Tidak ada Resiko Terjadi Dekubitus";
                                                                    }
                                                                    ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td width="30%">Kesimpulan</td>
                            <td><?php echo empty($integumen->kesimpulan) ? "-" : $integumen->kesimpulan; ?></td>
                        </tr>
                    </table>
                </div>
            <?php
            endif;
            ?>
            <?php if (in_array($instalasi_id, array(Params::INSTALASI_ID_RD, Params::INSTALASI_ID_RI, Params::INSTALASI_ID_PERAWATAN_INTENSIF, Params::INSTALASI_ID_PERSALINAN))) : ?>
                <?php
                echo $this->renderPartial('rawatJalan.views._periksaDataPasien.periksaFisik._cardio', array(
                    'modPemeriksaanFisik' => $loop
                ), true);
                ?>
                <?php
                echo $this->renderPartial('rawatJalan.views._periksaDataPasien.periksaFisik._pulmo', array(
                    'modPemeriksaanFisik' => $loop
                ), true);
                ?>
                <?php
                echo $this->renderPartial('rawatJalan.views._periksaDataPasien.periksaFisik._abdomen', array(
                    'modPemeriksaanFisik' => $loop
                ), true);
                ?>
                <?php
                echo $this->renderPartial('rawatJalan.views._periksaDataPasien.periksaFisik._obstetri', array(
                    'modPemeriksaanFisik' => $loop
                ), true);
                ?>
                <?php
                echo $this->renderPartial('rawatJalan.views._periksaDataPasien.periksaFisik._genitalia', array(
                    'modPemeriksaanFisik' => $loop
                ), true);
                ?>
            <?php else : ?>
                <?php
                echo $this->renderPartial('rawatJalan.views._periksaDataPasien.periksaFisik._abdomen', array(
                    'modPemeriksaanFisik' => $loop
                ), true);
                ?>
            <?php endif; ?>
            <?php
            echo $this->renderPartial('rawatJalan.views._periksaDataPasien.periksaFisik._ews', array(
                'model' => $loop
            ), true);
            ?>
            <?php if (!in_array($instalasi_id, array(Params::INSTALASI_ID_RD, Params::INSTALASI_ID_RI, Params::INSTALASI_ID_PERAWATAN_INTENSIF))) : ?>
                <div class="span12" style="border-top: 1px solid black;">
                    <table id="tblDaftarAnamnesa" width="100%">
                        <tr>
                            <td align="center" valign="middle" colspan="2" style="font-weight:bold"><b>Jalan Nafas</b></td>
                            <td align="center" valign="middle" colspan="2" style="font-weight:bold"><b>Pernapasan</b></td>
                        </tr>
                        <tr>
                            <td width="30%">Paten</td>
                            <td width="20%"><?php echo ($loop->jn_paten) ? '<b>&#8730</b>' : ' - '; ?></td>
                            <td width="30%">Simetri</td>
                            <td width="20%"><?php echo ($loop->pgd_simetri) ? '<b>&#8730</b>' : ' - '; ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Obstruktif Partial</td>
                            <td width="20%"><?php echo ($loop->jn_obstruktifpartial) ? '<b>&#8730</b>' : ' - '; ?></td>
                            <td width="30%">Asimetri</td>
                            <td width="20%"><?php echo ($loop->pgd_asimetri) ? '<b>&#8730</b>' : ' - '; ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Obstruktif Total</td>
                            <td width="20%"><?php echo ($loop->jn_obstruktifnormal) ? '<b>&#8730</b>' : ' - '; ?></td>
                            <td width="30%">Normal</td>
                            <td width="20%"><?php echo ($loop->pgp_normal) ? '<b>&#8730</b>' : ' - '; ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Stridor</td>
                            <td width="20%"><?php echo ($loop->jn_stridor) ? '<b>&#8730</b>' : ' - '; ?></td>
                            <td width="30%">Kussmaul</td>
                            <td width="20%"><?php echo ($loop->pgp_kussmaul) ? '<b>&#8730</b>' : ' - '; ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Gargling</td>
                            <td width="20%"><?php echo ($loop->jn_gargling) ? '<b>&#8730</b>' : ' - '; ?></td>
                            <td width="30%">Takipena</td>
                            <td width="20%"><?php echo ($loop->pgp_takipnea) ? '<b>&#8730</b>' : ' - '; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Pernapasan Gerak Dada</b></td>
                            <td width="30%">Retraktif</td>
                            <td width="20%"><?php echo ($loop->pgp_retraktif) ? '<b>&#8730</b>' : ' - '; ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Simetri</td>
                            <td width="20%"><?php echo ($loop->pgd_simetri) ? '<b>&#8730</b>' : ' - '; ?></td>
                            <td width="30%">Dangkal</td>
                            <td width="20%"><?php echo ($loop->pgp_dangkal) ? '<b>&#8730</b>' : ' - '; ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Asimetri</td>
                            <td width="20%"><?php echo ($loop->pgd_asimetri) ? '<b>&#8730</b>' : ' - '; ?></td>
                            <td width="30%"></td>
                            <td width="20%"></td>
                        </tr>
                    </table>
                </div>
                <div class="span12" style="border-top: 1px solid black;">
                    <table id="tblDaftarAnamnesa" width="100%">
                        <tr>
                            <td align="center" valign="middle" colspan="4" style="font-weight:bold"><b>Sirkulasi</b></td>
                        </tr>
                        <tr>
                            <td width="30%">Nadi Carotis</td>
                            <td width="20%"><?php echo ($loop->sirkulasi_nadicarotis) ? $loop->sirkulasi_nadicarotis . ' x/menit' : ' - '; ?></td>
                            <td width="30%"> Kulit Cyanosis</td>
                            <td width="20%"><?php echo ($loop->kulit_cyanosis) ? '<b>&#8730</b>' : ' - '; ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Nadi Radialis</td>
                            <td width="20%"><?php echo ($loop->sirkulasi_nadiradialis) ? $loop->sirkulasi_nadiradialis . ' x/menit' : ' - '; ?></td>
                            <td width="30%"> Kulit Pucat</td>
                            <td width="20%"><?php echo ($loop->kulit_pucat) ? '<b>&#8730</b>' : ' - '; ?></td>
                        </tr>
                        <tr>
                            <td width="30%">CFR</td>
                            <td width="20%">
                                <?php echo ($loop->cfr_kecil_2) ? '<b>&#8730</b>' : ' - '; ?> <= 2 &nbsp; &nbsp; <?php echo ($loop->cfr_besar_2) ? '<b>&#8730</b>' : ' - '; ?>>= 2
                            </td>
                            <td width="30%"> Kulit Berkeringat</td>
                            <td width="20%"><?php echo ($loop->kulit_berkeringat) ? '<b>&#8730</b>' : ' - '; ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Kulit Normal</td>
                            <td width="20%"><?php echo ($loop->kulit_normal) ? '<b>&#8730</b>' : ' - '; ?></td>
                            <td width="30%"> Akral</td>
                            <td width="20%"><?php echo ($loop->akral) ? $loop->akral : ' - '; ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Kulit Jaundice</td>
                            <td width="20%"><?php echo ($loop->kulit_jaundice) ? '<b>&#8730</b>' : ' - '; ?></td>
                            <td width="30%"></td>
                            <td width="20%"></td>
                        </tr>
                    </table>
                </div>
            <?php endif; ?>
            <?php if (!in_array($instalasi_id, array(Params::INSTALASI_ID_RD, Params::INSTALASI_ID_RI, Params::INSTALASI_ID_PERAWATAN_INTENSIF))) : ?>
                <div class="span12" style="border-top: 1px solid black;">
                    <table id="tblDaftarAnamnesa" width="100%">
                        <tr>
                            <td colspan="4"><b>Tanda Vital Janin</b></td>
                        </tr>
                        <tr>
                            <td colspan="2" width="30%">Denyut Jantung Janin</td>
                            <td colspan="2" width="70%"><?php echo !empty($modPemeriksaanFisik->denyutjantung_janin) ? $modPemeriksaanFisik->denyutjantung_janin : " - "; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" width="30%">Tinggi Fundus Uteri</td>
                            <td colspan="2" width="70%"><?php echo !empty($modPemeriksaanFisik->tinggifundus_uteri) ? $modPemeriksaanFisik->tinggifundus_uteri : " - "; ?></td>
                        </tr>
                    </table>
                </div>
            <?php endif; ?>
            <?php if (in_array($instalasi_id, array(Params::INSTALASI_ID_REHAB))) : ?>
                <div class="span12" style="border-top: 1px solid black;">
                    <table id="tblDaftarAnamnesa" width="100%">
                        <tr>
                            <td colspan="2"><b>Kekuatan Otot</b></td>
                            <td colspan="2"><b>Lingkup Gerak Sendi</b></td>
                        </tr>
                        <tr>
                            <td width="30%">Cybex</td>
                            <td width="20%"><?php echo empty($loop->kekuatanotot_cybex) ? "-" : $loop->kekuatanotot_cybex; ?></td>
                            <td width="30%">Iknometer</td>
                            <td width="20%"><?php echo empty($loop->lingkupgeraksendi_ikinometer) ? "-" : $loop->lingkupgeraksendi_ikinometer; ?></td>
                        </tr>
                        <tr>
                            <td width="30%">En-Tree</td>
                            <td width="20%"><?php echo empty($loop->kekuatanotot_entree) ? "-" : $loop->kekuatanotot_entree; ?></td>
                            <td width="30%">Goniometer</td>
                            <td width="20%"><?php echo empty($loop->lingkupgeraksendi_goniometer) ? "-" : $loop->lingkupgeraksendi_goniometer; ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Nk-Table</td>
                            <td width="20%"><?php echo empty($loop->kekuatanotot_nktable) ? "-" : $loop->kekuatanotot_nktable; ?></td>
                            <td width="30%"></td>
                            <td width="20%"></td>
                        </tr>
                        <tr>
                            <td width="30%">Hand-Held Dinamometer</td>
                            <td width="20%"><?php echo empty($loop->kekuatanotot_handhelddinamo) ? "-" : $loop->kekuatanotot_handhelddinamo; ?></td>
                            <td width="30%"></td>
                            <td width="20%"></td>
                        </tr>
                        <tr>
                            <td width="30%">Pinchmeter</td>
                            <td width="20%"><?php echo empty($loop->kekuatanotot_pinchmeter) ? "-" : $loop->kekuatanotot_pinchmeter; ?></td>
                            <td width="30%"></td>
                            <td width="20%"></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Fleksibilitas</b></td>
                            <td colspan="2"><b>Sensibilitas</b></td>
                        </tr>
                        <?php
                        $loop->sensibilitas_panasdingin = explode(":", $loop->sensibilitas_panasdingin);
                        $loop->sensibilitas_tajamtumpul = explode(":", $loop->sensibilitas_tajamtumpul);
                        $loop->sensibilitas_kasarhalus = explode(":", $loop->sensibilitas_kasarhalus);
                        $loop->sensibilitas_titik = explode(":", $loop->sensibilitas_titik);
                        ?>
                        <tr>
                            <td width="30%">Schober Test</td>
                            <td><?php echo empty($loop->fleksibilitas_schober) ? "-" : $loop->fleksibilitas_schober ?></td>
                            <td width="50%" colspan="2" style="text-align: center;"><i class="<?php echo in_array("Panas", $loop->sensibilitas_panasdingin) ? "entypo-check" : "entypo-cancel" ?>"></i> Panas / Dingin<i class="<?php echo in_array("Dingin", $loop->sensibilitas_panasdingin) ? "entypo-check" : "entypo-cancel" ?>"></i></td>
                        </tr>
                        <tr>
                            <td>Site And Reach Test</td>
                            <td><?php echo empty($loop->fleksibilitas_sitandreach) ? "-" : $loop->fleksibilitas_sitandreach ?></td>
                            <td width="50%" colspan="2" style="text-align: center;"><i class="<?php echo in_array("Tajam", $loop->sensibilitas_tajamtumpul) ? "entypo-check" : "entypo-cancel" ?>"></i> Tajam / Tumpul<i class="<?php echo in_array("Tumpul", $loop->sensibilitas_tajamtumpul) ? "entypo-check" : "entypo-cancel" ?>"></i></td>
                        </tr>
                        <tr>
                            <td>Shoulder Fleksibility Test</td>
                            <td><?php echo empty($loop->fleksibilitas_shoulderfleksibility) ? "-" : $loop->fleksibilitas_shoulderfleksibility ?></td>
                            <td width="50%" colspan="2" style="text-align: center;"><i class="<?php echo in_array("Kasar", $loop->sensibilitas_kasarhalus) ? "entypo-check" : "entypo-cancel" ?>"></i> Kasar / Halus<i class="<?php echo in_array("Halus", $loop->sensibilitas_kasarhalus) ? "entypo-check" : "entypo-cancel" ?>"></i></td>
                        </tr>
                        <tr>
                            <td>Tes Sentuh Jari Kaki</td>
                            <td><?php echo empty($loop->fleksibilitas_sentuhjarikaki) ? "-" : $loop->fleksibilitas_sentuhjarikaki ?></td>
                            <td width="50%" colspan="2" style="text-align: center;"><i class="<?php echo in_array("1 Titik", $loop->sensibilitas_titik) ? "entypo-check" : "entypo-cancel" ?>"></i>1 Titik / 2 Titik<i class="<?php echo in_array("2 Titik", $loop->sensibilitas_titik) ? "entypo-check" : "entypo-cancel" ?>"></i></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Kesimpulan : </b><br><?php echo empty($loop->fleksibilitas_kesimpulan) ? "-" : $loop->fleksibilitas_kesimpulan; ?></td>
                            <td colspan="2"><b>Saran : </b><br><?php echo empty($loop->fleksibilitas_saran) ? "-" : $loop->fleksibilitas_saran; ?></td>
                        </tr>
                    </table>
                </div>
                <div class="span12" style="border-top: 1px solid black;">
                    <table id="tblDaftarAnamnesa" width="100%">
                        <tr>
                            <td colspan='2' width='50%'><b>Kemampuan Fungsional</b></td>
                            <td colspan='2'><b>Pemeriksaan Sistematik Khusus</b></td>
                        </tr>
                        <tr>
                            <td colspan="2" rowspan='3'>
                                <ul>
                                    <?php
                                    if ($loop->fungsional_tidur) {
                                        echo "<li>";
                                        echo $loop->getAttributeLabel('fungsional_tidur');
                                        echo "</li>";
                                    }
                                    if ($loop->fungsional_jalansendiri) {
                                        echo "<li>";
                                        echo $loop->getAttributeLabel('fungsional_jalansendiri');
                                        echo "</li>";
                                    }
                                    if ($loop->fungsional_alatbantu) {
                                        echo "<li>";
                                        echo $loop->getAttributeLabel('fungsional_alatbantu');
                                        echo empty($loop->fungsional_alatbantu_keterangan) ? "" : " (" . $loop->fungsional_alatbantu_keterangan . ")";
                                        echo "</li>";
                                    }
                                    if ($loop->fungsional_kursiroda) {
                                        echo "<li>";
                                        echo $loop->getAttributeLabel('fungsional_kursiroda');
                                        echo "</li>";
                                    }
                                    if ($loop->fungsional_prothese) {
                                        echo "<li>";
                                        echo $loop->getAttributeLabel('fungsional_prothese');
                                        echo empty($loop->fungsional_prothese_keterangan) ? "" : " (" . $loop->fungsional_prothese_keterangan . ")";
                                        echo "</li>";
                                    }
                                    if ($loop->fungsional_deformitas) {
                                        echo "<li>";
                                        echo $loop->getAttributeLabel('fungsional_deformitas');
                                        echo empty($loop->fungsional_deformitas_keterangan) ? "" : " (" . $loop->fungsional_deformitas_keterangan . ")";
                                        echo "</li>";
                                    }
                                    if ($loop->fungsional_resikojatuh) {
                                        echo "<li>";
                                        echo $loop->getAttributeLabel('fungsional_resikojatuh');
                                        echo empty($loop->fungsional_resikojatuh_keterangan) ? "" : " (" . $loop->fungsional_resikojatuh_keterangan . ")";
                                        echo "</li>";
                                    }
                                    if ($loop->fungsional_lainlain) {
                                        echo "<li>";
                                        echo $loop->getAttributeLabel('fungsional_lainlain');
                                        echo empty($loop->fungsional_lainlain_keterangan) ? "" : " (" . $loop->fungsional_lainlain_keterangan . ")";
                                        echo "</li>";
                                    }
                                    ?>
                                </ul>
                            </td>
                            <td colspan="2">
                                <?php echo $loop->getAttributeLabel('sistematikkhusus_muskuloskeletal') ?>:<br>
                                <?php echo $loop->sistematikkhusus_muskuloskeletal; ?>
                                <br>
                                <br>
                                <?php echo $loop->getAttributeLabel('sistematikkhusus_neuromuscular') ?>:<br>
                                <?php echo $loop->sistematikkhusus_neuromuscular; ?>
                                <br>
                                <br>
                                <?php echo $loop->getAttributeLabel('sistematikkhusus_cardiopulmunal') ?>:<br>
                                <?php echo $loop->sistematikkhusus_cardiopulmunal; ?>
                                <br>
                                <br>
                                <?php echo $loop->getAttributeLabel('sistematikkhusus_integumen') ?>:<br>
                                <?php echo $loop->sistematikkhusus_integumen; ?>
                                <br>
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td colspan='2'><b>Pengukuran Khusus</b></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php echo $loop->getAttributeLabel('pengukurankhusus_muskuloskeletal') ?><br>
                                <?php echo $loop->pengukurankhusus_muskuloskeletal; ?>
                                <br>
                                <br>
                                <?php echo $loop->getAttributeLabel('pengukurankhusus_neuromuscular') ?><br>
                                <?php echo $loop->pengukurankhusus_neuromuscular; ?>
                                <br>
                                <br>
                                <?php echo $loop->getAttributeLabel('pengukurankhusus_cardiopulmunal') ?><br>
                                <?php echo $loop->pengukurankhusus_cardiopulmunal; ?>
                                <br>
                                <br>
                                <?php echo $loop->getAttributeLabel('pengukurankhusus_integumen') ?><br>
                                <?php echo $loop->pengukurankhusus_integumen; ?>
                                <br>
                                <br>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php endif; ?>
            <?php if (in_array($instalasi_id, array(Params::INSTALASI_ID_RD, Params::INSTALASI_ID_RI, Params::INSTALASI_ID_PERAWATAN_INTENSIF))) : ?>
                <div class="span12" style="border-top: 1px solid black;">
                    <table id="tblDaftarAnamnesa" width="100%">
                        <tr>
                            <td>
                                <b>Pemeriksaan Penunjang</b><br>
                                <?php echo !empty($loop->periksa_penunjang) ? $loop->periksa_penunjang : "-<br>" ?>
                                <b>Diagnosa Kerja</b><br>
                                <?php
                                $diag = DiagnosakerjaT::model()->findAllByAttributes(array(
                                    'pemeriksaanfisik_id' => $loop->pemeriksaanfisik_id,
                                ));
                                if (count((array)$diag) == 0) {
                                    echo "-<br>";
                                } else {
                                    echo "<ul>";
                                    foreach ($diag as $item) {
                                        echo "<li>" . $item->diagnosakerja_isi . "</li>";
                                    }
                                    echo "</ul>";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Terapi IGD</b><br>
                                <?php echo !empty($loop->terapi_igd) ? $loop->terapi_igd : "-" ?><br>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Terapi Rawat Inap</b><br>
                                <?php echo !empty($loop->terapi_rawatinap) ? $loop->terapi_rawatinap : "-" ?><br>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Monitoring</b><br>
                                <?php echo !empty($loop->monitoring) ? $loop->monitoring : "-" ?><br>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="span12" style="border-top: 1px solid black;">
                    <table id="tblDaftarAnamnesa" width="100%">
                        <tr>
                            <td colspan="2"><b>Rencana Tindak Lanjut</b></td>
                        </tr>
                        <tr>
                            <td width="30%">Rawat Inap Ruang</td>
                            <td><?php echo !empty($loop->tl_rawatinap_ruang) && trim($loop->tl_rawatinap_ruang) != "" ? $loop->tl_rawatinap_ruang : "-"; ?></td>
                        </tr>
                        <tr>
                            <td>Rawat Inap DPJP</td>
                            <td><?php echo !empty($loop->tl_rawatinap_dpjp) && trim($loop->tl_rawatinap_dpjp) != "" ? $loop->tl_rawatinap_dpjp : "-"; ?></td>
                        </tr>
                        <tr>
                            <td>Indikasi</td>
                            <td><?php echo !empty($loop->tl_indikasi) && trim($loop->tl_indikasi) != "" ? $loop->tl_indikasi : "-"; ?></td>
                        </tr>
                        <tr>
                            <td>Pengantar Pasien</td>
                            <td><?php echo empty($loop->tl_pengantar_pasien) && trim($loop->tl_pengantar_pasien) != "" ? "Tidak" : "Ya"; ?></td>
                        </tr>
                        <tr>
                            <td>Rujuk ke</td>
                            <td><?php
                                if (empty($loop->tl_asalrujukan_id)) {
                                    echo "-";
                                } else {
                                    $asal = AsalrujukanM::model()->findByPk($loop->tl_asalrujukan_id);
                                    if (empty($asal)) {
                                        echo "-";
                                    } else {
                                        echo $asal->asalrujukan_nama . ", " . $loop->tl_rujuk_nama;
                                    }
                                }
                                ?></td>
                        </tr>
                    </table>
                </div>
                <div class="span12" style="border-top: 1px solid black;">
                    <table id="tblDaftarAnamnesa" width="100%">
                        <tr>
                            <td>
                                <b>Edukasi Pasien</b><br>
                                Edukasi awal, disampaikan tentang Diagnosis, Rencana, dan Tujuan Terapi Kepada :</br>
                                <?php
                                if (empty($loop->edukasi_dituju_ke)) {
                                    echo "-";
                                } else {
                                    echo $loop->edukasi_dituju_ke;
                                    if ($loop->edukasi_dituju_ke == "KELUARGA") {
                                        echo " (" . $loop->edukasi_nama_keluarga . ")";
                                    } else if ($loop->edukasi_dituju_ke == "TIDAK BISA") {
                                        echo " karena, " . $loop->edukasi_alasan_tidakbisa;
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        <hr style="border-bottom: 1px solid black;">
        <?php
        if ($instalasi_id == Params::INSTALASI_ID_REHAB) {
            // Asesmen Nyeri (Fisioterapi)
            $modFlaCcs = new AsesmennyeriflaccsT;
            $dataFlaCcs = array();
            $getFlaCcs = null;
            $cekFlaCcs = array();
            $criFla = new CDbCriteria();
            $criFla->select = " t.*,  ksn.kat_skalanyeri_nama ";
            $criFla->join = " JOIN kategoriskalanyeri_m ksn ON ksn.kat_skalanyeri_id = t.kat_skalanyeri_id ";
            $criFla->addCondition(" skalanyeriflaccs_aktif = TRUE ");
            $modNyeriFlaCcs = SkalanyeriflaccsM::model()->findAll($criFla);
            foreach ($modNyeriFlaCcs as $dtF) {
                $datas = AsesmennyeriflaccsT::model()->findByAttributes(array(
                    'pemeriksaanfisik_id' => $loop->pemeriksaanfisik_id,
                    'skalanyeriflaccs_id' => $dtF->skalanyeriflaccs_id,
                ));
                $dataFlaCcs["$dtF->kat_skalanyeri_id"]["kategori"] = $dtF->kat_skalanyeri_nama;
                $dataFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"][] = array(
                    'id' => $dtF->skalanyeriflaccs_id,
                    'keterangan' => $dtF->skalanyeriflaccs_desc,
                    'value' => empty($datas) ? false : true,
                );
            }
        ?>
            <table id="tblDaftarAnamnesa">
                <tr>
                    <td colspan="2"><b>Data Asesmen Nyeri</b></td>
                </tr>
                <tr>
                    <td width="30%">Apakah ada nyeri</td>
                    <td><?php echo $loop->keluhan_nyeri ? "Ada, " . $loop->skala_wongbaker_nrs : "Tidak"; ?></td>
                </tr>
                <?php if ($loop->keluhan_nyeri) : ?>
                    <tr>
                        <td colspan="2">
                            <?php
                            echo $this->renderPartial('rawatJalan.views.pemeriksaanFisik.pemeriksaan/rehab/_formNyeriDetail', array(
                                'modFisik' => $loop,
                                //'modAsesTriase'=>$modAsesTriase,
                                'modFlaCcs' => $modFlaCcs,
                                'dataFlaCcs' => $dataFlaCcs,
                                'getFlaCcs' => $getFlaCcs
                            ), true);
                            ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </table>
        <?php } ?>
        <div class="row" style="font-size: 8pt; font-weight: bold; border-top: 1px solid black; border-bottom: 2px solid black; padding: 5px;">
            Dibuat Oleh : <?php
                            $login = LoginpemakaiK::model()->findByPk($loop->create_loginpemakai_id);
                            if (!empty($login->pegawai)) {
                                echo $login->pegawai->namaLengkap;
                            } else {
                                echo $login->nama_pemakai ?? '';
                            }
                            ?>
        </div>
    <?php
    }
} else {
    ?>
    * Tidak ada pemeriksaan fisik
<?php } ?>
<!--</table>-->