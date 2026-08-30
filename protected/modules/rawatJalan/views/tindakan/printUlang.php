<style>
html * {
    font-size: 10pt !important;
}

/* .status * {
    font-size: 5pt !important;
} */

.tr-status td {
    font-size: 10pt !important;
}

#daftar-tindakan * {
    font-size: 10pt !important;
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
#daftar-tindakan td,
#daftar-tindakan th {
    border-collapse: collapse;
    border-left: 1px solid transparent;
    border-right: 1px solid transparent;
}
</style>
<table style="width: 100%; border: none;">
    <thead>
        <tr>
            <?php
                $rs = ProfilrumahsakitM::model()->find();
            ?>
            <td colspan="2"><?php echo $rs->nama_rumahsakit ?></td>
        </tr>
        <tr>
            <td style="width: 90%;"><?php echo $rs->alamatlokasi_rumahsakit ?></td>
            <td style="float: right;"><?php echo "Hal. $i" ?> <br> Cetakan ke <?= $i ?></td>
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
                                    $ins_login = Yii::app()->user->getState('instalasi_id');
                                    $rgn_login = Yii::app()->user->getState('ruangan_id');

                                    $instalasi = InstalasiM::model()->findByPk($ins_login);
                                    $ruangan = RuanganM::model()->findByPk($rgn_login);
                                ?>
                                <?php echo $instalasi->instalasi_singkatan . " / " . $ruangan->ruangan_nama; ?>
                            </td>
                            <td style="">Kelas</td>
                            <td style="">:</td>
                            <td><?php echo !empty($modPendaftaran->kelaspelayanan_id) ? $modPendaftaran->kelaspelayanan->kelaspelayanan_nama : "-"; ?>
                            </td>
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
                                    <tbody>
                                        <?php $total = 0; ?>
                                        <?php foreach ($modTindakans as $i => $modTindakan) { 
                                                if($i != 'total_biaya') {
                                                    $hideTotalBiaya = 'hidden';
                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $nomulai + 1 . ". "?></td>
                                                <td><?php echo $modTindakan->daftartindakan->daftartindakan_kode ?></td>
                                                <td>
                                                    <?php 
                                                    if ( $modTindakan->daftartindakan->daftartindakan_nama=='Perawatan Rawat Inap' and $modTindakan->create_ruangan==Params::RUANGAN_ID_PERINATOLOGI){
                                                        echo 'Ruang Perinatologi';
                                                    }else{
                                                        echo $modTindakan->daftartindakan->daftartindakan_nama;
                                                    }

                                                    echo ' ';

                                                    echo isset($modTindakan->konsulpoli->pegawaikonsul) ? "(" . $modTindakan->konsulpoli->pegawaikonsul->namaLengkap . ")" : '(SYSADMIN)';                                                ?>
                                                

                                                </td>
                                                <td style="text-align: right;">Rp. <?php echo !empty($modTindakan->tarif_tindakan) ? MyFormatter::formatNumberForPrint($modTindakan->tarif_tindakan, 2) : '' ?>
                                                </td>
                                            </tr>

                                        <?php 
                                                } else {
                                                    $hideTotalBiaya = '';
                                                    $total = $modTindakan;
                                                }
                                                $nomulai++;
                                            // $total += intval($modTindakan->tarif_tindakan);
                                    
                                        } ?>
                                    </tbody>
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
                <?php echo $nopendaftaran . $modTindakans[0]->nopelayanan; ?></b>
            </td>
            <td style="width: 10%; text-align: right;" <?= $hideTotalBiaya ?>>
                <b>Total Biaya </b>
            </td>
            <td style="width: 20%; text-align: right;" <?= $hideTotalBiaya ?>>
                <b>Rp. <?php echo MyFormatter::formatNumberForPrint($total, 2); ?>&emsp;</b>
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
<?php 
if(isset($count) && isset($k) && $k == $count) { 
    if($hideTotalBiaya == 'hidden') {
        echo '<div class="footer-tindakan"></div>';
    } else {
        echo '<div class="page-break"></div>';
    }
} else {
    
        echo '<div class="footer-tindakan"></div>';

    
} 
?>

