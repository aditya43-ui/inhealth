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
            <td style="float: right;"><?php echo "Hal. $hal" ?></td>
        </tr>
        <tr>
            <?php
                $cetakanke = $modTindakans[0]->cetakan;
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
                                <td> <?php echo "-"; ?> </td>
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
                                            <?php $tot = 0; $no = ($offset + 1); ?>
                                            <?php foreach ($modTindakans as $i => $modTindakan) { ?>
                                            <tr class="tr-white">
                                                <td class="td-white" style="border: none !important;">
                                                    <?php 

                                                    $is_last = isset($is_last) ? $is_last : true;
                                                    $is_first = isset($is_first) ? $is_first : true;

                                                    if(($offset) > 0) {
                                                        echo $no++ . '. ';
                                                    } else{
                                                        echo $i + 1 . ". ";
                                                    }
                                                    // echo ' -- last: ' . $is_last;
                                                    // echo ' -- first: ' . $is_first;
                                                    // echo ' -- offset: ' . $offset;
                                                ?>
                                                </td>
                                                <td class="td-white" style="border: none !important;">
                                                    <?php echo $modTindakan->daftartindakan->daftartindakan_kode ?></td>
                                                <td class="td-white" style="border: none !important;">
                                                    <?php 

                                                $nama = '';

                                                  if ( $modTindakan->daftartindakan->daftartindakan_nama=='Perawatan Rawat Inap' && $modTindakan->create_ruangan==Params::RUANGAN_ID_PERINATOLOGI){
                                                      $nama = 'Ruang Perinatologi';
                                                  } else if(!empty($modTindakan->pemeriksaanrad_id)) {
                                                    //   $nama = $modTindakan->pemeriksaanrad->pemeriksaanrad_nama;
                                                      $daftartindakan = PemeriksaanradM::model()->findByPk($modTindakan->pemeriksaanrad_id);
                                                      $nama = $daftartindakan->pemeriksaanrad_nama;
                                                    //   echo $modTindakan->daftartindakan_id;
                                                  } else{
                                                      $nama = $modTindakan->daftartindakan->daftartindakan_nama;
                                                  }

                                                  echo $nama;

                                                  echo ' ';

                                                //   echo isset($modTindakan->konsulpoli->pegawaikonsul) ? "(" . $modTindakan->konsulpoli->pegawaikonsul->namaLengkap . ")" : '(SYSADMIN)';
                                                  
                                                  $tarif = !empty($modTindakan->tarif_tindakan) ? MyFormatter::formatNumberForPrint($modTindakan->tarif_tindakan, 2) : '';

                                                  if(empty($tarif)) {
                                                      $tariftindakan = TariftindakanM::model()->find("daftartindakan_id = $modTindakan->daftartindakan_id");
                                                        $tarif = $tariftindakan->harga_tariftindakan;
                                                  }

                                                  $tot += MyFormatter::formatNumberForDb($tarif);

                                                //   var_dump(MyFormatter::formatNumberForDb($tarif), $tarif);
                                                  
                                                  ?>

                                                

                                                </td>
                                                <td class="td-white"
                                                    style="border: none !important; text-align: right;">Rp.
                                                    <?php echo $tarif ?>
                                                </td>
                                            </tr>

                                            <?php } ?>
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
                /*
                    if(!empty($modPendaftaran->pasienadmisi_id)) {
                        $modPasienAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
                        if($modTindakans[0]->tgl_tindakan >= $modPasienAdmisi->tgladmisi) {
                            $nopendaftaran = str_replace(["RD", 'RJ'], "RI", $modPendaftaran->no_pendaftaran);
                        } else {
                            $nopendaftaran = $modPendaftaran->no_pendaftaran;
                        }
                    } else {
                        $nopendaftaran = $modPendaftaran->no_pendaftaran;
                    }
                    */
                ?>
                <?php echo $modTindakans[0]->noNota ?? "-"; //$nopendaftaran . $modTindakans[0]->nopelayanan; ?></b>
        </td>
        <td style="width: 10%; text-align: right;" <?php echo (!$is_last) ? 'hidden' : ''?>>
            <b>Total Biaya </b>
        </td>
        <td style="width: 20%; text-align: right;" <?php echo (!$is_last) ? 'hidden' : ''?>>
            <?php //echo '<pre>'; var_dump($total); die; ?>
            <?php $ttl = !empty($total->total_tarif) ? $total->total_tarif : $tot; ?>
            <b>Rp. <?php echo MyFormatter::formatNumberForPrint(strval($ttl), 2); ?>&emsp;</b>
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
                        <?php 
                        
                        $login = LoginpemakaiK::model()->findByPk($modTindakans[0]->create_loginpemakai_id);
                        echo $login->pegawai->namaLengkap;
                        
                        // echo PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'))->namaLengkap 
                        ?>
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
<?php if(isset($is_last) && $is_last == true) { ?>
<div class="page-break"></div>
<?php } else {?>
<div class="footer-tindakan"></div>
<?php } ?>