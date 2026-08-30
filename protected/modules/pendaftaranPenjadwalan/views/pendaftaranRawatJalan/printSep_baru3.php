<?php $data = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
<?php
if (!empty($modSep->json_response)) {
    $res = CJSON::decode($modSep->json_response);
    if (!empty($res['response'])) {
        $modSep->diagnosaawal = $res['response']['sep']['diagnosa'];
        // $modSep->klsrawat = $res['response']['sep']['kelasRawat'];
    }
}


?>
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Arial">

<style>
    .barcode-label {
        margin-top: -20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 8px;
        transform: scale(0.1);
    }

    td {
        font-size: 8pt !important;
    }

    body {
        width: 19.7cm;
    }

    td.header {
        padding-left: 30px;
    }

    td {
        font-size: 7pt !important;
        vertical-align: top;
    }

    .qr_data img {
        max-width: none;
        width: 50px;
    }

    @page {
        font-size: 9pt !important;
    }

    @media print {

        html,
        body {
            font-family: "Arial" !important;
            font-size: 9pt !important;
            color: black;
        }
    }
</style>
<table width="80%" border="0" style="text-align:left;">
    <thead>
        <th width="25%"><img src="<?php echo Yii::app()->getBaseUrl('webroot') . '/images/logo_bpjs.png'; ?>" width="200px"></th>
        <th style="font-weight:bold; text-align: left;"><span style="font-size:15px;"><?php echo $judul_print; ?><br><?php echo $data->nama_rumahsakit; ?></span></th>

        <th>
            <?php
            if (!empty($modSep->programprb_nama) && $modSep->programprb_nama != "-" && $data_sep['poli'] != "INSTALASI GAWAT DARURAT") {
                echo $modSep->programprb_nama;
            }
            ?>
        </th>
    </thead>
</table>
<table width="100%" border="0" style="text-align:left;">
    <tbody>
        <td colspan="4">
            <table border="0" style="text-align:left;">
                <tr>
                    <td width="12%">No. SEP</td>
                    <td width="1%">:</td>
                    <td width="35%">
                        <div style="font-size: 8pt;"><b><?php //echo $modSep->nosep; 
                                                        if (date('Ymd', strtotime($modSep->tglsep)) < date('Ymd', strtotime($modPendaftaran->tgl_pendaftaran))) {
                                                            echo $modSep->nosep . " (Backdate)";
                                                        } else {
                                                            echo $modSep->nosep;
                                                        }
                                                        ?></b></div>
                    </td>
                    <?php if (!empty($modSep->katarak)) { ?>
                        <td>Katarak</td>
                        <td>:</td>
                        <td>YA</td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>Tgl. SEP</td>
                    <td>:</td>
                    <td><?php echo date('Y-m-d', strtotime($modSep->tglsep)); ?></td>
                    <td width="12%">Peserta</td>
                    <td width="1%">:</td>
                    <td width="35%"><?php echo isset($modAsuransiPasienBpjs->jenispeserta_bpjs) ? $modAsuransiPasienBpjs->jenispeserta_bpjs : '-'; ?></td>
                </tr>
                <tr hidden>
                    <td>No SRK</td>
                    <td>:</td>
                    <td><b><?php echo !empty($modSep->no_surat) ? $modSep->no_surat : '-'; ?></b></td>
                    <td>COB</td>
                    <td>:</td>
                    <td><?php echo ($modSep->cob == 0) ? "-" : $modSep->no_asuransi_cob . "-" . $modSep->namaasuransi_cob; ?></td>
                </tr>
                <tr hidden>
                    <td>Tgl. SEP</td>
                    <td>:</td>
                    <td><?php echo date('Y-m-d', strtotime($modSep->tglsep)); ?></td>
                    <td>Prolanis PRB</td>
                    <td>:</td>
                    <td><?php echo empty($modAsuransiPasienBpjs->bpjs_prolanisprb) ? "-" : $modAsuransiPasienBpjs->bpjs_prolanisprb; ?></td>
                </tr>
                <tr>
                    <td>No. Kartu</td>
                    <td>:</td>
                    <td>
                        <div style="font-size: 8pt;"><?php echo $modSep->nokartuasuransi; ?> ( MR .<?php echo $modPasien->no_rekam_medik; ?>)</div>
                    </td>

                </tr>
                <tr>
                    <td>Nama Peserta</td>
                    <td>:</td>
                    <td><?php echo $modAsuransiPasienBpjs->namapemilikasuransi; ?></td>
                    <td>Jns. Rawat</td>
                    <td>:</td>
                    <td><?php echo ($modSep->jnspelayanan == 2) ? "R. Jalan" : "R. Inap"; ?></td>

                </tr>
                <tr>
                    <td>Tgl. Lahir</td>
                    <td>:</td>
                    <td><?php echo date('Y-m-d', strtotime($modPasien->tanggal_lahir)); ?>, Kelamin : <?php echo ucfirst(strtolower($modPasien->jeniskelamin)); ?> </td>
                    <td>Jns. Kunjungan</td>
                    <td>:</td>
                    <td colspan="2"><?php
                                    $datJenis = LookupM::model()->findByAttributes(array(
                                        'lookup_value' => $modSep->jenis_kunjungan,
                                        'lookup_type' => 'bpjs_jnskunjungan',
                                    ));
                                    $datProsedur = LookupM::model()->findByAttributes(array(
                                        'lookup_value' => $modSep->flag_procedure,
                                        'lookup_type' => 'bpjs_flagprocedure',
                                    ));

                                    if (!empty($datJenis)) {
                                        echo $datJenis->lookup_name;
                                    } else {
                                        "-";
                                    }

                                    $kunjungan = "";
                                    if ($modSep->politujuan == "IGD") {
                                        $kunjungan = "Kunjungan Pertama";
                                    } else {
                                        $sepDat = SepT::model()->countByAttributes(array(
                                            'nosep' => $modSep->nosep,
                                        ));

                                        if ($sepDat > 1) {
                                            $kunjungan = "Kunjungan Ke-" . $sepDat;
                                        } else {
                                            $kunjungan = "Kunjungan Pertama";
                                        }
                                    }
                                    // if (!empty($kunjungan)) {
                                    //     echo " (" . $kunjungan . ")";
                                    // }

                                    if (!empty($datProsedur)) {
                                        echo "<br/>";
                                        echo "- " . $datProsedur->lookup_name;
                                    }

                                    ?></td>

                </tr>
                <tr>
                    <td>No. Telepon</td>
                    <td>:</td>
                    <td><?php echo $modSep->no_telpon_peserta; ?></td>
                    <td>Poli Perujuk</td>
                    <td>: </td>
                    <td colspan="2"><?php echo $modSep->polirujukan; ?></td>

                </tr>
                <tr>
                    <td>Sub/Spesialis</td>
                    <td>:</td>
                    <td><?php
                        if (!empty($modSep->politujuan)) {
                            $rpoli = RuanganM::model()->countByAttributes(array(
                                'kode_bpjs' => $modSep->politujuan,
                            ));

                            if ($rpoli > 1) {
                                $spoli = RuanganM::model()->findByAttributes(array(
                                    'kode_bpjs' => $modSep->politujuan,
                                    'ruangan_id' => $modPendaftaran->ruangan_id
                                ));

                                if (empty($spoli)) {
                                    $spoli = RuanganM::model()->findByAttributes(array(
                                        'kode_bpjs' => $modSep->politujuan,
                                    ));
                                }

                                if (!empty($spoli)) {
                                    echo $spoli->ruangan_nama;
                                } else {
                                    echo $modSep->politujuan;
                                }
                            } else {
                                $spoli = RuanganM::model()->findByAttributes(array(
                                    'kode_bpjs' => $modSep->politujuan,
                                ));

                                if (!empty($spoli)) {
                                    echo $spoli->ruangan_nama;
                                } else {
                                    echo $modSep->politujuan;
                                }
                            }
                        } else {
                            echo "-";
                        }
                        ?></td>
                    <td>Kls. Hak</td>
                    <td>:</td>
                    <td colspan="2"><?php

                                    $kelas = KelaspelayananM::model()->findByAttributes(array(
                                        'kelasbpjs_id' => $modSep->klsrawat,
                                    ));

                                    $kelasLayanan = KelaspelayananM::model()->findByPk($modPendaftaran->kelaspelayanan_id);

                                    if ($modSep->jnspelayanan == 1) {
                                        $modPasienadmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
                                        if (!empty($modPasienadmisi)) {
                                            $kelasLayanan = KelaspelayananM::model()->findByPk($modPasienadmisi->kelaspelayanan_id);
                                        }
                                    }


                                    $kelasTanggunan = KelaspelayananM::model()->findByAttributes(array('kelaspelayanan_id' => $modAsuransiPasienBpjs->kelastanggunganasuransi_id));
                                    // var_dump($modAsuransiPasienBpjs->kelastanggunganasuransi_id); die;

                                    $is_naik = true;
                                    if (empty($kelasLayanan->kelasbpjs_id)) {
                                        // echo $kelasLayanan->kelaspelayanan_nama;
                                    } else if ($kelasLayanan->kelasbpjs_id > $kelas->kelasbpjs_id) {
                                        // echo $kelasLayanan->kelaspelayanan_nama;
                                    } else {
                                        // echo $kelas->kelaspelayanan_nama;
                                        $is_naik = false;
                                    }
                                    echo $data_sep['peserta']['hakKelas']; // echo (($modSep->jnspelayanan == 2) ? ("Kelas " . $kelas->kelasbpjs_id) : (!empty($kelasTanggunan) ? ("Kelas " . $kelasTanggunan->kelasbpjs_id) : ""));
                                    ?></td>

                </tr>
                <tr>
                    <td>Dokter</td>
                    <td>:</td>
                    <td><?php

                        if ($modSep->jnspelayanan == 1) {
                            echo $modSep->nama_dpjp;
                        } else if ($modSep->jnspelayanan == 2) {
                            echo $modSep->dpjpygmelayani_nama;
                        }

                        ?></td>

                </tr>
                <tr>
                    <td>Faskes Perujuk</td>
                    <td>:</td>
                    <td>
                        <?php
                        if ($modSep->jnspelayanan != 2) {
                            $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
                            $modRujukanDari = RujukandariM::model()->findByAttributes(array('kodeppk' => $modProfilRs->ppkpelayanan));
                            echo $modRujukanDari->namaperujuk;
                        } else {
                            if (empty($modAsuransiPasienBpjs->nama_feskestk1) || $modAsuransiPasienBpjs->nama_feskestk1 == "") {
                                $modPendaftaran = PendaftaranT::model()->findByAttributes(array('sep_id' => $modSep->sep_id));
                                if (!empty($modPendaftaran->rujukan_id)) {
                                    $modRujukan = RujukanT::model()->findByPk($modPendaftaran->rujukan_id);
                                    echo $modRujukan->nama_perujuk;
                                }
                            } else {
                                echo $modAsuransiPasienBpjs->nama_feskestk1;
                            }
                        }

                        ?>
                    </td>
                    <td>Kls. Rawat</td>
                    <td>:</td>
                    <td colspan="2">
                    <?php
                        $modPasienadmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
                        if (!empty($modPasienadmisi) && !empty($data_sep['klsRawat']['klsRawatNaik'])) {
                            $kelas = KelaspelayananM::model()->findByPk($modPasienadmisi->kelaspelayanan_id);
                            $kelasRawat = $kelas->kelaspelayanan_nama;
                            if ($kelas->kelasnaikbpjs_id != 8){ //default kelas vip dan VVIP
                                $kelasRawat = 'Kelas ' . $kelas->kelasbpjs_id;
                            }
                            // $kelasRawat = "Kelas ". $data_sep['klsRawat']['klsRawatNaik'];
                        }else{
                            $kelasRawat = "Kelas ". $data_sep['klsRawat']['klsRawatHak'];
                        }
                        echo (($modSep->jnspelayanan == 2) ? "-" : ($kelasRawat)); //echo "Kelas " . $data_sep['klsRawat']['klsRawatHak'];
                        ?>
                    </td>

                </tr>
                <tr>
                    <td>Diagnosa Awal</td>
                    <td>:</td>
                    <td style="text-align:justify;font-size: 7pt !important;"><?php echo $modSep->diagnosaawal . " " . $modSep->nama_diagnosaawal; ?></td>
                    <td>Penjamin</td>
                    <td>:</td>
                    <td colspan="2"><?php $modSep->penjamin_lakalantas; ?></td>
                </tr>
                <tr>
                    <td>Catatan</td>
                    <td>:</td>
                    <td colspan="5" style="font-size: 8pt !important;"><?php echo $modSep->catatansep; ?></td>
                </tr>

                <tr>
                    <td colspan="3">&nbsp;</td>
                    <!-- <td colspan="3" style="font-size: 7pt !important;">*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan<br>*SEP bukan sebagai bukti penjaminan peserta<br>**Dengan tampilan luaran SEP elektronik ini merupakan hasil validasi terhadap elibigilitas Pasien secara elektronik (validasi finger print atau biometrik / sistem validasi lain) dan selanjutnya Pasien dapat mengakses pelayanan kesehatan berlaku. Kebenaran dan keaslian atas informasi data Pasien menjadi tanggung jawab penuh FKRTL</td> -->
                    <td align="left" colspan="3" style="font-size: 7pt !important;">Pasien/Keluarga Pasien</td>
                    <td></td>
                    <!-- <td align="center" style="font-size: 8pt !important;">Petugas Rumah Sakit</td> -->
                </tr>
                <tr>
                    <td colspan="3" style="font-size: 5pt !important;">*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan<br>*SEP bukan sebagai bukti penjaminan peserta<br>**Dengan tampilan luaran SEP elektronik ini merupakan hasil validasi terhadap eligibilitas Pasien secara elektronik (validasi finger print atau biometrik / sistem validasi lain) dan selanjutnya Pasien dapat mengakses pelayanan kesehatan rujukan sesuai ketentuan berlaku. Kebenaran dan keaslian atas informasi data Pasien menjadi tanggung jawab penuh FKRTL</td>

                    <td width="8%" class="qr_data">
                        <center>
                            <?php
                            $this->widget('ext.qrcode.QRCodeGenerator', array(
                                'data' => $modSep->nokartuasuransi,
                                'subfolderVar' => false,
                                'displayImage' => true, // default to true, if set to false display a URL path
                                'errorCorrectionLevel' => 'L', // available parameter is L,M,Q,H
                                'matrixPointSize' => 6, // 1 to 10 only
                            ))
                            ?>
                        </center>

                    </td>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <?php if (empty($modSep->ttd_link)) { ?>
                    <tr>
                        <td colspan="7">&nbsp;</td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="3" style="font-size: 6pt !important;">Cetakan ke -<?php echo $modSep->print_ke;
                                                                                    ?> <?php echo date('d/m/Y H:i:s');
                                                                                        ?><?php //echo $_SERVER['REMOTE_ADDR']; 
                                                                                            ?></td>
                    <td colspan="3" align="left" style="font-size: 7pt !important;"><?php echo $modAsuransiPasienBpjs->namapemilikasuransi; ?></td>

                    <td></td>
                    <!-- <td align="center"><?php //echo Yii::app()->user->getState('nama_pegawai'); 
                                            ?></td> -->
                </tr>
            </table>
        </td>
    </tbody>
</table>