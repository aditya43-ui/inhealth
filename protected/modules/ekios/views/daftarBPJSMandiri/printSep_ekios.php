<?php $data = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
<?php
// if (!empty($modSep->json_response)) {
//     $res = CJSON::decode($modSep->json_response);
//     if (!empty($res['response'])) {
//         $modSep->diagnosaawal = $res['response']['sep']['diagnosa'];

//         if (!empty($res['response']['sep']['peserta']['jnsPeserta'])) {
//             $modAsuransiPasienBpjs->jenispeserta_bpjs = $res['response']['sep']['peserta']['jnsPeserta'];
//         }

//         // $modSep->klsrawat = $res['response']['sep']['kelasRawat'];
//     }
// }


?>
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Arial">

<style>
    .barcode-label {
        margin-top: -20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }

    td {
        font-size: 10pt !important;
    }

    body {
        width: 21.7cm;
    }

    td.header {
        padding-left: 30px;
    }

    td {
        font-size: 11pt !important;
        vertical-align: top;
    }

    .qr_data img {
        max-width: none;
        width: 100px;
        padding-left: 10px;
    }

    @page {
        font-size: 11pt !important;
        margin-top: 40px;
    }

    @media print {

        html,
        body {
            font-family: "Arial" !important;
            font-size: 11pt;
            color: black;
            margin-top: 10px;
        }
    }
</style>
<table width="100%" border="0" style="text-align:left;">
    <thead>
        <th width="25%"><img src="<?php echo Yii::app()->getBaseUrl('webroot') . '/images/logo_bpjs.png'; ?>" width="200px"></th>
        <th style="font-weight:bold; text-align: left;"><span style="font-size:17px;"><?php echo $judul_print; ?><br><?php echo $data->nama_rumahsakit; //." (".Yii::app()->user->getState('ppkpelayanan').")"; 
                                                                                                                        ?></span></th>
        <!--th align='right' width="25%" style="font-weight:bold;"><span style="font-size:17px;"><?php // echo $modAsuransiPasienBpjs->jenispeserta_bpjs; 
                                                                                                    ?></span></th-->
        <!--<th  style = "padding: 0;"><!--<img src="<?php //echo Params::urlProfilRSDirectory().$data->logo_rumahsakit   
                                                        ?>" width="120px"></th>-->
        <th style="padding-top: 40px;" width="93px">
            <center>
                <?php //echo '<b>' . $modPendaftaran->ruangan->ruangan_singkatan . "-" . $modPendaftaran->no_urutantri . '</b>'; 
                ?>
            </center>
        </th>
    </thead>
</table>
<table width="100%" border="0" style="text-align:left;">
    <tbody>
        <td colspan="4">
            <table border="0" style="text-align:left;">
                <tr>
                    <td width="16%">No. SEP</td>
                    <td width="1%">:</td>
                    <td width="39%">
                        <b><?php //echo $modSep->nosep; 
                            if (date('Ymd', strtotime($modSep->tglsep)) < date('Ymd', strtotime($modPendaftaran->tgl_pendaftaran))) {
                                echo $modSep->nosep . " (Backdate)";
                            } else {
                                echo $dataSep->noSep;//$modSep->nosep;
                            }
                            ?></b>
                    </td>
                    <td width="15%">Peserta</td>
                    <td width="1%">:</td>
                    <td width="20%"><?php echo isset($modAsuransiPasienBpjs->jenispeserta_bpjs) ? $modAsuransiPasienBpjs->jenispeserta_bpjs : '-'; ?></td>
                    <td width="8%" class="qr_data" rowspan="6">
                        <span style="margin-left:20px;font-size:15px;font-weight:bold;"><?php echo '<b>' . $modPendaftaran->ruangan->ruangan_singkatan . "-" . $modPendaftaran->no_urutantri . '</b>'; ?></span><br>
                        <?php
                        $this->widget('ext.qrcode.QRCodeGenerator', array(
                            'data' => $modSep->nosep,
                            'subfolderVar' => false,
                            'displayImage' => true, // default to true, if set to false display a URL path
                            'errorCorrectionLevel' => 'L', // available parameter is L,M,Q,H
                            'matrixPointSize' => 10, // 1 to 10 only
                        ))
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>No SRK</td>
                    <td>:</td>
                    <td><b><?php echo !empty($modSep->no_surat) ? $modSep->no_surat : '-'; ?></b></td>
                    <td>COB</td>
                    <td>:</td>
                    <td><?php echo ($modSep->cob == 0) ? "-" : $modSep->no_asuransi_cob . "-" . $modSep->namaasuransi_cob; ?></td>
                </tr>
                <tr>
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
                    <td><?php echo $dataSep->peserta->noKartu;//$modSep->nokartuasuransi; ?> / <b>RM : <?php echo $dataSep->peserta->noMr;//$modPasien->no_rekam_medik; ?></b> </td>
                    <td>Jns. Rawat</td>
                    <td>:</td>
                    <td><?php echo $dataSep->jnsPelayanan;//($modSep->jnspelayanan == 2) ? "R. Jalan" : "R. Inap"; ?></td>
                </tr>
                <tr>
                    <td>Nama Peserta</td>
                    <td>:</td>
                    <td><?php echo $dataSep->peserta->nama;//$modAsuransiPasienBpjs->namapemilikasuransi; ?></td>
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

                                    // $kunjungan = "";
                                    // if ($modSep->politujuan == "IGD") {
                                    //     $kunjungan = "Kunjungan Pertama";
                                    // } else {
                                    //     $sepDat = SepT::model()->countByAttributes(array(
                                    //         'nosep'=>$modSep->nosep,
                                    //     ));

                                    //     if ($sepDat > 1) {
                                    //         $kunjungan = "Kunjungan Ke-".$sepDat;
                                    //     } else {
                                    //         $kunjungan = "Kunjungan Pertama";
                                    //     }
                                    // }
                                    // if (!empty($kunjungan)) {
                                    //     echo " (".$kunjungan.")";
                                    // }

                                    if (!empty($datProsedur)) {
                                        echo "<br/>";
                                        echo "- " . $datProsedur->lookup_name;
                                    }

                                    ?></td>
                </tr>
                <tr>
                    <td>Tgl. Lahir</td>
                    <td>:</td>
                    <td><?php echo date('Y-m-d', strtotime($modPasien->tanggal_lahir)); ?>, Kelamin : <?php echo ucfirst(strtolower($modPasien->jeniskelamin)); ?> </td>
                    <td>Poli Perujuk</td>
                    <td>: </td>
                    <td colspan="2"><?php echo '-'; ?></td>
                </tr>
                <tr>
                    <td>No. Telepon</td>
                    <td>:</td>
                    <td><?php echo $modSep->no_telpon_peserta; ?></td>
                    <td>Kls. Hak</td>
                    <td>:</td>
                    <td colspan="2"><?php

                                    $kelas = KelaspelayananM::model()->findByAttributes(array(
                                        'kelasbpjs_id' => $modSep->klsrawat,
                                    ));

                                    // var_dump($kelas->attributes); die;

                                    $kelasLayanan = KelaspelayananM::model()->findByPk($modPendaftaran->kelaspelayanan_id);

                                    if ($modSep->jnspelayanan == 1) {
                                        $modPasienadmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
                                        if (!empty($modPasienadmisi)) {
                                            $kelasLayanan = KelaspelayananM::model()->findByPk($modPasienadmisi->kelaspelayanan_id);
                                        }
                                    }


                                    // $kelasTanggunan = KelaspelayananM::model()->findByAttributes(array('kelaspelayanan_id' => $modAsuransiPasienBpjs->kelastanggunganasuransi_id));
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
                                    echo 'Kelas '.$dataSep->klsRawat->klsRawatHak;//(($modSep->jnspelayanan == 2) ? ("Kelas " . $kelas->kelasbpjs_id) : (!empty($kelasTanggunan) ? ("Kelas " . $kelasTanggunan->kelasbpjs_id) : ""));
                                    ?></td>
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
                                    echo $spoli->ruangan_namalainnya;
                                } else {
                                    echo $modSep->politujuan;
                                }
                            } else {
                                $spoli = RuanganM::model()->findByAttributes(array(
                                    'kode_bpjs' => $modSep->politujuan,
                                ));

                                if (!empty($spoli)) {
                                    echo $spoli->ruangan_namalainnya;
                                } else {
                                    echo $modSep->politujuan;
                                }
                            }
                        } else {
                            echo "-";
                        }
                        ?></td>
                    <td>Kls. Rawat</td>
                    <td>:</td>
                    <td colspan="2"><?php
                                    echo (($modSep->jnspelayanan == 2) ? "-" : "Kelas " . ($kelas->kelasbpjs_id));
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
                    <td>Penjamin</td>
                    <td>:</td>
                    <td colspan="2"><?php $modSep->penjamin_lakalantas; ?></td>
                </tr>
                <tr>
                    <td>Faskes Perujuk</td>
                    <td>:</td>
                    <td>
                        <?php
                         echo $modAsuransiPasienBpjs->nama_feskestk1;
                        // if (empty($modAsuransiPasienBpjs->nama_feskestk1) || $modAsuransiPasienBpjs->nama_feskestk1 == "") {
                        //     $modPendaftaran = PendaftaranT::model()->findByAttributes(array('sep_id' => $modSep->sep_id));
                        //     if (!empty($modPendaftaran->rujukan_id)) {
                        //         $modRujukan = RujukanT::model()->findByPk($modPendaftaran->rujukan_id);
                        //         echo $modRujukan->nama_perujuk;
                        //     }
                        // } else {
                        //     echo $modAsuransiPasienBpjs->nama_feskestk1;
                        // }
                        ?>
                    </td>
                    <td>Catatan</td>
                    <td>:</td>
                    <td colspan="5">
                        <?php echo !empty($modSep->catatansep) ? $modSep->catatansep : ''; ?>
                    </td>
                </tr>
                <tr>
                    <td>Diagnosa Awal</td>
                    <td>:</td>
                    <?php
                    $diagnosaawal = strlen($modSep->diagnosaawal);
                    $nama_diagnosaawal = strlen($modSep->nama_diagnosaawal);
                    $jml = $diagnosaawal + $nama_diagnosaawal;
                    $diagnosa = '';

                    if ($diagnosaawal > 85) {
                        $diagnosa = substr($modSep->nama_diagnosaawal, 0, 10) . '...';
                    } else if ($jml > 85) {
                        $sisa = 85 - $diagnosaawal;
                        $diagnosa = $modSep->diagnosaawal . " " . substr($modSep->nama_diagnosaawal, 0, $sisa) . '...';
                    }

                    ?>
                    <td colspan="5"><?php echo $modSep->diagnosaawal . "-" . substr($modSep->nama_diagnosaawal, 0, 30); ?></td>
                </tr>
                <tr>
                    <td colspan="3" style="font-size: 7pt !important;">*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan<br>*SEP bukan sebagai bukti penjaminan peserta</td>
                    <td align="center" style="font-size: 11pt !important;">Pasien/Keluarga Pasien</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <!-- <td align="center" style="font-size: 8pt !important;">Petugas Rumah Sakit</td> -->
                </tr>
                <tr>
                    <?php if (empty($modSep->ttd_link)) { ?>
                        <td colspan="7">&nbsp;</td>
                    <?php } else {
                        $url = Params::urlSignSepDirectory() . $modSep->ttd_link;
                    ?>
                        <td colspan="3">&nbsp;</td>
                        <td colspan="2">
                            <center>
                                <img src="<?= $url ?>" width="50mm" height="50mm">
                            </center>
                        </td>
                        <td colspan="2">&nbsp;</td>
                    <?php } ?>
                </tr>
                <?php if (empty($modSep->ttd_link)) { ?>
                    <tr>
                        <td colspan="7">&nbsp;</td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="3" style="font-size: 8pt !important;">Cetakan Ke-<?php echo $modSep->print_ke; ?> (<?php echo date('d/m/Y H:i:s'); ?>)</td>
                    <!-- ) SIMARS INNOVA eHospital / <?php //echo $_SERVER['REMOTE_ADDR']; 
                                                        ?></td> -->
                    <td align="center">_____________</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <!-- <td align="center"><?php //echo Yii::app()->user->getState('nama_pegawai'); 
                                            ?></td> -->
                </tr>
            </table>
        </td>
    </tbody>
</table>