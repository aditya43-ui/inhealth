<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
    body {
        width: 22cm;
    }

    .letters,
    .letters table td {
        font-family: serif !important;
        line-height: .5cm;
        font-size: 12px;
    }

    .heads td {
        line-height: normal;
    }

    .heads td>div {
        font-family: serif !important;
        line-height: normal;
        font-size: 16px;
    }

    .ind {
        margin-left: 1cm;
        /*margin-bottom: 0.5cm;*/
        /*margin-top: 0.5cm;*/
    }

    .judul {
        text-align: center;
        font-size: 18px;
        font-family: serif !important;
        font-weight: bold;
        /*text-decoration: underline;*/
        margin-top: .5cm;
        margin-bottom: .5cm;
    }

    .borderclass {
        border: 1px solid black;
    }

    .bordertopclass {
        border-top: 1px solid black;
    }

    .borderrightclass {
        border-right: 1px solid black;
    }

    .borderleftclass {
        border-left: 1px solid black;
    }

    .borderbottomclass {
        border-bottom: 1px solid black !important;
    }

    .padding5 {
        padding: 5px;
    }
</style>



<div class="letters">
    <div class="heads">
        <?php echo $this->renderPartial('_headerPrint', array('modAdmisi' => $modAdmisi)); ?>
        <?php // echo $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._headerPrintStatus'); 
        ?>
    </div>

    <div class="judul"><u>SURAT KONTROL BEROBAT</u></div>
    <div class="judul"><?php echo !empty($sk->nomorsurat) ? $sk->nomorsurat : '-'; ?></div>
    <br />
    <!--Saya yang bertanda tangan dibawah ini, Dokter RSUD ABPURA, dengan ini menerangkan bahwa :<br/>-->
    <table class="ind">
        <tr>
            <td width="150">Nama</td>
            <td>: <?php echo $modPasien->namadepan . $modPasien->nama_pasien; ?></td>
            <tr />
        <tr>
            <td>Jenis Kelamin</td>
            <td>: <?php echo $modPasien->jeniskelamin; ?></td>
        </tr>
        <tr>
            <td>Tempat/ Tanggal Lahir</td>
            <td>: <?php echo $modPasien->tempat_lahir . " / " . MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir); ?></td>
        </tr>
        <tr>
            <td>No. Rekam Medis</td>
            <td>: <?php echo $modPasien->no_rekam_medik; ?></td>
        </tr>
        <tr>
            <td>Tanggal Dirawat</td>
            <td>: <?php echo MyFormatter::formatDateTimeForUser($modAdmisi->tgladmisi) ?></td>
        </tr>
        <tr>
            <td>Tanggal Pulang</td>
            <td>: <?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($modAdmisi->rencanapulang))) ?></td>
        </tr>
        <tr>
            <td>Ruangan Perawatan</td>
            <td>: <?php echo $modAdmisi->ruangan->ruangan_nama . ' / ' . $modMasukKamar->kamarruangan->kamarruangan_nokamar . ' : ' . $modMasukKamar->kamarruangan->kamarruangan_nobed; ?></td>
        </tr>
        <tr>
            <td>Tindakan
            <td>: <?php echo nl2br(!empty($sk->kontrolri_tindakan) ? $sk->kontrolri_tindakan : '-'); ?></td>
        </tr>
        <tr>
            <td>Terapi Pulang
            <td>: <?php echo nl2br(!empty($sk->kontrolri_terapipulang) ? $sk->kontrolri_terapipulang : '-'); ?></td>
        </tr>
        <tr>
            <td>Kontrol Ke Poliklinik
            <td>: <?php echo $modPendaftaran->ruangankontrol->ruangan_nama; ?><br /> <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tglrenkontrol) ?></td>
        </tr>
        <tr>
            <td>Dokter Tujuan Kontrol
            <td>: <?php
                    if (!empty($modPendaftaran->doktertujuankontrol_id)) {
                        $peg = PegawaiM::model()->findByPk($modPendaftaran->doktertujuankontrol_id);

                        echo empty($peg) ? "-" : $peg->namaLengkap;
                    } else {
                        echo "-";
                    }
                    ?></td>
        </tr>
        <?php if (!empty($sk->nomorsurat_bpjs)) : ?>
            <tr>
                <td>No. Surat Kontol BPJS
                <td>: <?php echo $sk->nomorsurat_bpjs; ?></td>
            </tr>
        <?php endif; ?>
    </table>
    <br /><br />
    <table>
        <tr>
            <table width="100%">
                <tr>
                    <td style="width:40%; text-align: left;" colspan="2">
                    </td>
                    <td style="width:20%; text-align: left;" colspan="2">
                    </td>
                    <td style="width:40%; text-align: left;" colspan="2">
                        <center><?php echo Yii::app()->user->getState('kabupaten_nama') ?>, <?php echo date('d') . ' ' . MyFormatter::getMonthId(date('m')) . ' ' . date('Y'); ?><br />Dokter yang Merawat
                            <br><br><br><br><br><br>
                            <?php echo $modAdmisi->pegawai->namaLengkap; ?>
                        </center>
                    </td>
                </tr>
            </table>

            <!--Supaya pasien diatas dapat melakukan rencana kontrol pada :-->
            <?php
            //$tgl = date('Y-m-d', strtotime($modPendaftaran->tgl_pendaftaran));
            //$tgl = date('Y-m-d', strtotime($modPendaftaran->tglrenkontrol));
            ?>
            <!--<table class="ind">
    <tr>
        <td width="150">Tanggal<td>: <?php // echo MyFormatter::formatDateTimeForUser($tgl); 
                                        ?></td>
    </tr>
    <tr>
        <td>Poliklinik</td><td>: <?php // echo $modPendaftaran->ruangankontrol->ruangan_nama; 
                                    ?></td>
    </tr>
</table>-->

            <!--Surat ini hanya berlaku untuk <strong>satu kali kunjungan</strong> pada tanggal <strong><?php // echo MyFormatter::formatDateTimeForUser($tgl); 
                                                                                                        ?></strong>
selama jam pelayanan.<br/><br/>
Demikian Surat Rencana Kontrol ini dibuat untuk dipergunakan seperlunya.<br/><br/>-->


            <!--        <td width="100%"></td>
        <td nowrap style="text-align: center">
            <?php // echo Yii::app()->user->getState('kecamatan_nama').", ".MyFormatter::formatDateTimeForUser(date("Y-m-d")); 
            ?>
            <br/>
            <br/>
            <br/>
            <br/>
            <u><?php // echo $modAdmisi->pegawai->namaLengkap; 
                ?></u><br/>
            <?php // echo $modAdmisi->pegawai->nomorindukpegawai; 
            ?>
        </td>
    </tr>-->

            <!--</table>-->


</div>