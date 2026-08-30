<style>
html * {
    font-size: 10pt !important;
    /* font-family: 'Times New Roman', Times, serif !important; */
    color: black;
}
/* 
table {
    font-family: 'Times New Roman', Times, serif !important;
} */
/* .status * {
    font-size: 5pt !important;
} */

.tr-status td {
    font-size: 10pt !important;
}

#daftar-tindakan * {
    font-size: 10pt !important;
}
#daftar-tindakan tr td {
    padding: 0 !important;
}


.barcode-label {
    margin-top: -20px;
    z-index: 1;
    text-align: center;
    letter-spacing: 10px;
}

.footer-tindakan {
    page-break-after: always;
}

.page-break {
    page-break-inside: avoid;
}

#daftar-tindakan tr,
#daftar-tindakan td {
    border-collapse: collapse;
    border: none;
}

#daftar-tindakan th {
    border-collapse: collapse;
    border-left: 1px solid white;
    border-right: 1px solid white;
}

table tr, table td {
    vertical-align: top;
}

.td-white {
    border: none;
}
</style>

<table style="width: 100%; border: none;">
    <thead>
        <tr>
            <?php
                $rs = ProfilrumahsakitM::model()->find();
            ?>
            <td colspan="2"><?php echo str_replace("MALANG", "", $rs->nama_rumahsakit) ?></td>
        </tr>
        <tr>
            <td style="width: 90%;"><?php echo $rs->alamatlokasi_rumahsakit . ' Malang' ?></td>
            <td style="float: right;"><?php echo "Hal. " . $page ?></td>
        </tr>
        <tr>
            <?php
                $cetakanke = $page;
            ?>
            <td></td>
            <td  style="float: right;"><?php echo "Cetakan Ke $cetakanke"?></td>
        </tr>
        <tr>
            <td><br><br></td>
        </tr>

    </thead>
    <tbody>
        <tr>
            <td colspan="3">
                <div class="content">

                    <table class="status" width="100%">
                        <tbody class="body-status">
                            <tr class="tr-status">
                                <td align="center" valig="middle" colspan="6">
                                    <b>NOTA TINDAKAN / PEMERIKSAAN / PEL. LAIN</b>
                                </td>
                            </tr>
                            <tr class="tr-status">
                                <td style="width: 20%;">Nama</td>
                                <td style="width: 1%;">:</td>
                                <td style="width: 50%;"><?php echo $modPendaftaran->pasien->nama_pasien; ?></td>
                                <td style="width: 15%;">No. Billing</td>
                                <td style="width: 1%;">:</td>
                                <td><?php echo $modPendaftaran->no_pendaftaran; ?></td>
                            </tr>
                            <tr class="tr-status">
                                <td style="">Alamat</td>
                                <td style="">:</td>
                                <td style=""><?php echo $modPendaftaran->pasien->alamat_pasien; ?></td>
                                <td style="">No. RM</td>
                                <td style="">:</td>
                                <td><?php echo $modPendaftaran->pasien->no_rekam_medik; ?></td>
                            </tr>
                            <tr class="tr-status">
                                <td style="">Tempat Layanan</td>
                                <td style="">:</td>
                                <td style="">
                                <?php 
                                    // var_dump(Yii::app()->user->getState('modul_id'));
                                    $ruangan_nama = '';
                                    $modul_id = Yii::app()->user->getState('modul_id');
                                    // var_dump($modul_id);die;
                                    if($modul_id == Params::MODUL_ID_LAB || $modul_id == Params::MODUL_ID_RAD || $modul_id == Params::MODUL_ID_APOTEK) {
                                        $tempatlayanan = RuanganM::model()->findByPk($modTindakans[0]->create_ruangan);
                                        if(!empty($tempatlayanan)) {
                                            echo $tempatlayanan->ruangan_nama;
                                        } else {
                                            echo Yii::app()->user->getState('ruangan_nama');
                                        }
                                    } else {
                                        echo Yii::app()->user->getState('ruangan_nama');
                                        // $modTindakans->ruangan->ruangan_nama;
                                        // if (!empty($kirim)) {
                                        //     $tempatlayanan = RuanganM::model()->findByPk($kirim->create_ruangan);
                                        // } else if (!empty($penunjang)) {
                                        //     $tempatlayanan = RuanganM::model()->findByPk($penunjang->ruangan_id);
                                        // } else {
                                        //     $tempatlayanan = RuanganM::model()->findByPk($modTindakans[0]->create_ruangan);
                                        // }
                                        // $ruangan_nama = $tempatlayanan->ruangan_nama;
                                    }
                                    ?>
                                    
                                    <?php echo $ruangan_nama; ?>
                                </td>
                                <td style="">Kelas</td>
                                <td style="">:</td>
                                <td> - </td>
                            </tr>
                            <tr class="tr-status">
                                <td style="">Jenis Pembayaran</td>
                                <td style="">:</td>
                                <td style=""><?php echo $modPendaftaran->carabayar->carabayar_nama; ?></td>
                                <td style="">Tgl. Kunjungan</td>
                                <td style="">:</td>
                                <td><?php echo !empty($modPendaftaran->tgl_pendaftaran) ? date('d-m-Y', strtotime($modPendaftaran->tgl_pendaftaran)) : "-"; ?>
                                </td>
                            </tr>


                            <tr>
                                <td align="center" valig="middle" colspan="6">
                                    <table class="table table-bordered" id="daftar-tindakan" style="">
                                        <thead>
                                            <th>No.</th>
                                            <th>Kode</th>
                                            <th>Uraian Tarif</th>
                                            <th style="text-align: right;">Jumlah Biaya</th>
                                        </thead>
                                        <tbody class="bd-white">
                                           
                                            <?php 
                                            
                                            foreach ($dataNotaTindakan as $i => $data) { 
                                                   
                                                            
                                            ?>
                                                <tr class="tr-white">
                                                    <td class="td-white" style="border: none !important;"><?= $i+1 ?></td>
                                                    <td class="td-white" style="border: none !important;"><?= $data['daftartindakan_kode'] ?></td>
                                                    <td class="td-white" style="border: none !important;"><?= $data['daftartindakan_nama'] ?></td>
                                                    <td class="td-white" style="border: none !important; text-align: right;">
                                                        <?= MyFormatter::formatUang($data['tarif_satuan'], 'Rp') ?>
                                                    </td>
                                                </tr>
                                            <?php 
                                            } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" style="border-top: 1px solid black; line-height: 1px;"></td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </td>
        </tr>
</table>
<table style="width: 100%;">
    <tr>
        <td style="width: 70%;">
            <b>No. Nota :
            <?php

            $ct = new CDbCriteria;
            $ct->select = 'distinct create_time, create_ruangan, pendaftaran_id, nopelayanan';
            $ct->addCondition('create_ruangan = ' . Yii::app()->user->getState('ruangan_id') . ' and pendaftaran_id = ' . $modPendaftaran->pendaftaran_id);
            $jmltin = TindakanpelayananT::model()->findAll($ct);

            ?>
            <?php 
            if(!empty($modPendaftaran->pasienadmisi_id)) {
                $modPasienAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
                //if($modTindakans[0]->tgl_tindakan >= $modPasienAdmisi->tgladmisi) {
                    $tgl_tindakan = strtotime($modTindakans[0]->tgl_tindakan);
                    $tgl_admisi = empty($modPasienAdmisi) ? null : strtotime($modPasienAdmisi->tgladmisi);
                if (
                    !empty($modTindakans[0]->pasienadmisi_id) 
                    || in_array($modTindakans[0]->instalasi_id, Params::grupInstalasiRIID())
                    || (!empty($tgl_admisi) && $tgl_tindakan > $tgl_admisi)
                    ) {
                    $nopendaftaran = str_replace(["RD", 'RJ'], "RI", $modPendaftaran->no_pendaftaran);
                } else {
                    $nopendaftaran = $modPendaftaran->no_pendaftaran;
                }
            } else {
                $nopendaftaran = $modPendaftaran->no_pendaftaran;
            }
            ?>
            <?php echo $nopendaftaran . $noPelayanan; ?></b>
        </td>
        <td style="width: 10%; text-align: right;" <?= ($halamanAkhir === true) ? '' : 'hidden' ?>>
            <b>Total Biaya </b>
        </td>
        <td style="width: 20%; text-align: right;" <?= ($halamanAkhir === true) ? '' : 'hidden' ?>>
            <?php //echo '<pre>'; var_dump($total); die; ?>
            <b><?= MyFormatter::formatUang($totalBiaya, 'Rp') ?>&emsp;</b>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <br>
            <table style="width: 100%;">
                <tr>
                    <td style="width: 30%;"></td>
                    <td style="width: 40%;"></td>
                    <td style="width: 30%; text-align: center; ">Malang, <?php echo date('d-m-Y'); ?></td>
                </tr>
                <tr>
                    <td>Lembar 1: Loket Pembayaran</td>
                    <td style="text-align: center;">Telah Diverifikasi</td>
                    <td style="width: 30%; text-align: center; ">Petugas Billing</td>
                </tr>
                <tr>
                    <td>Lembar 2: Tempat Layanan</td>
                    <td style="text-align: center;"></td>
                    <td style="width: 30%; text-align: center; "></td>
                </tr>
                <tr>
                    <td><br><br><br></td>
                    <td style="text-align: center;"><br><br><br></td>
                    <td style="width: 30%; text-align: center; "><br><br><br></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center;">
                        (&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;)
                    </td>
                    <td style="width: 30%; text-align: center; ">
                        <?php echo PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'))->namaLengkap ?>
                    </td>

                </tr>
            </table>
        </td>
    </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <!-- <div class="footer-space">&nbsp;</div> -->
            </td>
        </tr>
    </tfoot>
</table>
<?php if($halamanAkhir) { ?>
<div class="page-break"></div>
<?php } else {?>
<div class="footer-tindakan"></div>
<?php } ?>