<style>
    @page {
  size: A4;
  margin: 0;
}
@media print {
  html, body {
    width: 210mm;
    height: 297mm;
  }
  .footerclass{
      right: 0; bottom: 0; position: fixed; font-weight: bold;
  }
  /* ... the rest of the rules ... */
}
.footerclass{
      right: 0; bottom: 0; float: right; font-weight: bold;
  }
    body{
        color: black !important;
    }
    h5{
        color: black !important;
    }
    .tab_header {
        width: 100%;
    }

    .pilihan_ijin, .pilihan_privasi {
        font-weight: bold;
        cursor: pointer;
    }

    p {
        text-align: justify;
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

    .padding5{
        padding: 5px;
    }


    .wrapper {
  height: 100vh;
  display: flex;

  flex-direction: column;
}

header, footer {
      height: 30px;
}

main {
  flex: 1;
}

body {
  margin: 0;
}

 .tablefont td{
        color: black;
        padding: 5px;
    }

    .classbraketr{
        page-break-after: always;
    }
</style>


<?php
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();
?>

<table width="100%">
    <thead>
        <tr>
            <td>
                <div class="header"><div style="float: right !important; font-weight: bold">RM RI. 15.a REV 03</div></div>
            </td>
        </tr>
    </thead>
    <tbody>
    <div class="content">
        <tr>
            <td>
                 <?php echo $this->renderPartial($this->path_view.'_headerSuratPrint', array('pendaftaran'=>$modPendaftaran,'model'=>$model,'modPasien'=>$modPasien)); ?>
        <br />
        <table width="100%" class="borderclass">
            <tr>
                <td width="50%" style="padding:10px">
                    <table width="100%" class="tablefont">
                        <tr>
                            <td width="200px">Jenis Kelamin</td>
                            <td width="10px">:</td>
                            <td><?php echo $modPasien->jeniskelamin; ?></td>
                        </tr>
                        <tr>
                            <td>Ruangan Asal</td>
                            <td>:</td>
                            <td><?php echo $model->ruanganasal->instalasi->instalasi_nama.'/ '.$model->ruanganasal->ruangan_nama; ?></td>
                        </tr>
                        <tr>
                            <td>Waktu Transfer</td>
                            <td>:</td>
                            <td><?php echo $model->waktu_transfer; ?></td>
                        </tr>
                        <tr>
                            <td>Diagnosa Masuk RS</td>
                            <td>:</td>
                            <td><?php echo $model->diagnosamasukrs; ?></td>
                        </tr>
                    </table>
                </td>
                <td width="50%" valign="top" style="padding:10px">
                    <table width="100%" class="tablefont">
                        <tr>
                            <td width="200px">Tanggal Transfer</td>
                            <td width="10px">:</td>
                            <td><?php echo MyFormatter::formatDateTimeForUser($model->tanggal_transfer); ?></td>
                        </tr>
                        <tr>
                            <td>Ruangan yang dituju</td>
                            <td>:</td>
                            <td> <?php echo $model->instalasitujuan->instalasi_nama.'/ '.$model->ruangantujuan->ruangan_nama; ?></td>
                        </tr>
                        <tr>
                            <td>Waktu Tiba</td>
                            <td>:</td>
                            <td> <?php echo (!empty($modProsesTransfer->setelahtransfer_waktutiba)? $modProsesTransfer->setelahtransfer_waktutiba: '-'); ?></td>
                        </tr>
                        <tr>
                            <td>Indikasi Dirawat</td>
                            <td>:</td>
                            <td> <?php echo $model->indikasidirawat; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table width="100%" class="borderclass" style="margin-top:5px">
            <tr class="borderclass">
                <td style="padding:5px">I. Ringkasan Riwayat Pasien</td>
            </tr>
            <tr>
                <td style="padding:10px">
                    <table width="100%" class="tablefont">
                        <tr>
                            <td width="100px">Pukul</td>
                            <td width="10px">:</td>
                            <td><?php echo $model->jamringkas_riwayatpasien; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding:10px">
                    <table width="100%">
                        <tr>
                            <td colspan="2" style="font-weight: bold; color: black;">Anamnesis</td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <table width="100%" class="tablefont">
                                    <tr>
                                        <td width="150px">Keluhan Utama</td>
                                        <td width="10px">:</td>
                                        <td><?php echo $model->dokter_keluhanutama; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="200px">Riwayat Penyakit</td>
                                        <td width="10px">:</td>
                                        <td><?php echo $model->riwayatpenyakitterdahulu; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Riwayat Alergi</td>
                                        <td>:</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="padding-left: 20px;">
                                            <?php echo $model->riwayatalergi; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Keadaan Umum</td>
                                        <td>:</td>
                                        <td><?php echo $model->dokter_keadaanumum; ?></td>
                                    </tr>
                                </table>
                            </td>
                            <td width="50%" valign="top">
                                <table width="100%" class="tablefont">
                                    <tr>
                                        <td colspan="3">Pemeriksaan Tanda Vital</td>
                                    </tr>
                                    <tr>
                                        <td width="150px" style="padding-left:100px">Tensi</td>
                                        <td width="10px">:</td>
                                        <td> <?php echo $model->ttvdokter_td_systolic.'/ '.$model->ttvdokter_td_diastolic; ?> mmHg</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:100px">Suhu</td>
                                        <td>:</td>
                                        <td> <?php echo $model->ttvdokter_suhutubuh; ?> &#176 Celcius</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:100px">Nadi</td>
                                        <td>:</td>
                                        <td> <?php echo $model->ttvdokter_nadi; ?> x/menit </td>
                                    </tr>
                                    <tr>
                                        <td>Alasan Ditransfer</td>
                                        <td>:</td>
                                        <td> <?php echo $model->alasanditransfer; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kebutuhan Pelayanan</td>
                                        <td>:</td>
                                        <td> <?php echo $model->kebutuhanpelayanan; ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table width="100%" class="borderclass" style="margin-top:5px">
            <tr>
                <td class="borderclass" colspan="2" style="padding:5px">II. Ringkasan Riwayat Pasien</td>
            </tr>
            <tr>
                <td style="padding:10px">
                    <?php echo $model->dokter_ringkasanriwayatpasien; ?>
                    
                </td>
            </tr>
        </table>

        <table width="100%" class="borderclass" style="margin-top:5px">
            <tr>
                <td class="borderclass" colspan="2" style="padding:5px">III. Tindakan Medis yang Sudah Dilakukan</td>
            </tr>
            <tr>
                <td style="padding:10px">
                    <?php echo $model->dokter_tindakanmedisygdilakukan; ?>
                    <?php
                        // if(count($modTindakans) >0){
                        //     $htmlTindakan = "";
                        //     $index= 0;
                        //     foreach ($modTindakans as $i => $dataTindakan){
                        //         if($dataTindakan->daftartindakan->daftartindakan_periksa==true){
                        //             if($index >0){
                        //                 $htmlTindakan .= "<br />";
                        //             }
                        //             $htmlTindakan .= "- ".$dataTindakan->daftartindakan->daftartindakan_nama .', '.MyFormatter::formatDateTimeForUser($dataTindakan->tgl_tindakan);
                        //             $index++;
                        //         }
                        //     }
                        //
                        //     echo $htmlTindakan;
                        // }

                    ?>
                </td>
            </tr>
        </table>
        <table width="100%" class="borderclass" style="margin-top:5px">
            <tr>
                <td class="borderclass" style="padding:5px">IV. Pemberian Terapi</td>
            </tr>
            <tr>
                <td style="padding:10px">
                  <?php echo $model->dokter_pemberianterapi; ?>
                    <!-- <p style="font-weight: bold; color: black">Pemakaian Bahan Habis Pakai (BHP)</p> -->
                    <!-- <table class="borderclass" style="width: 40%">
                        <thead>
                            <th style="padding:5px" class="borderclass">Tgl. Pemakaian</th>
                            <th style="padding:5px" class="borderclass">Jenis Obat Alkes</th>
                            <th style="padding:5px" class="borderclass">Nama Obat Alkes</th>
                            <th style="padding:5px" class="borderclass">Jumlah</th>
                        </thead>
                        <tbody> -->
                    <?php

                    // if(count($modRiwayatResepBHP) > 0){
                    // foreach ($modRiwayatResepBHP as $i => $bmhp) { ?>
                        <!-- <tr>
                            <td style="padding:5px" class="borderclass">
                                <?php //echo $bmhp->tglpelayanan; ?>
                            </td>
                            <td style="padding:5px" class="borderclass">
                                <?php //echo (isset($bmhp->obatalkes->jenisobatalkes)? $bmhp->obatalkes->jenisobatalkes->jenisobatalkes_nama: ""); ?>
                            </td>
                            <td style="padding:5px" class="borderclass">
                                <?php //echo $bmhp->obatalkes->obatalkes_nama; ?>
                            </td>
                            <td style="padding:5px" class="borderclass" style="text-align:right;">
                                <?php //echo $bmhp->qty_oa; ?>
                            </td> -->
                        <!-- </tr> -->
                    <?php //} ?>
                    <?php  //}else{ ?>
                        <!-- <tr>
                            <td class="borderclass" colspan="4">Tidak ditemukan hasil.</td>
                        </tr> -->
                        <?php //} ?>
                        <!-- </tbody>
                    </table>
                    <br/>
                    <p style="font-weight: bold; color: black">Resep</p> -->
                    <?php
                        // if(count($modRiwayatResep) > 0){
                        //     foreach ($modRiwayatResep as $dataResep){
                        //         $modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id'=>$dataResep->reseptur_id));
                                ?>
                                <!-- <table style="width: 80%">
                                    <tr>
                                        <td style="width:100px">Tanggal Resep</td>
                                        <td>: <?php //echo MyFormatter::formatDateTimeForUser($dataResep->tglreseptur); ?></td>
                                        <td style="width:100px">Nama Dokter</td>
                                        <td>: <?php //$pegawaiResep = PegawaiM::model()->findByPk($dataResep->pegawai_id); echo isset($pegawaiResep)?$pegawaiResep->namaLengkap:"-"; ?></td>
                                    </tr>
                                    <tr>
                                        <td>No. Resep</td>
                                        <td>: <?php //echo $dataResep->noresep; ?></td>
                                    </tr>
                                </table>
                                <table class="borderclass" style="width: 40%">
                                    <thead>
                                        <th style="padding:5px" class="borderclass">Nama Obat Alkes</th>
                                        <th style="padding:5px" class="borderclass">Signa</th>
                                        <th style="padding:5px" class="borderclass">Jumlah</th>
                                    </thead>
                                    <tbody> -->
                                         <?php
                                        // if(count($modDetailResep) > 0){
                                        //     foreach ($modDetailResep as $dataDetResep){
                                                ?>
                                                    <!-- <tr>
                                                        <td class="borderclass"><?php //echo $dataDetResep->obatalkes->obatalkes_nama ?></td>
                                                        <td class="borderclass"><?php //echo $dataDetResep->signa_reseptur; ?></td>
                                                        <td class="borderclass" style="text-align: right"><?php //echo $dataDetResep->qty_reseptur." ".$dataDetResep->satuankecil->satuankecil_nama ?></td>
                                                    </tr> -->
                                                <?php
                                            // }
                                        // } ?>
                                    <!-- </tbody>
                                </table> -->
                               <?php
                        //     }
                        // }
                    ?>
                </td>
            </tr>
        </table>
        <table width="100%" class="borderclass" style="margin-top:5px">
            <tr>
                <td class="borderclass" style="padding:5px">V. Lain-lain</td>
            </tr>
            <tr>
                <td style="padding:10px">
                    <?php echo $model->dokter_catatanlainlain; ?>
                </td>
            </tr>
        </table>
        <br />
        <table width="100%">
            <tr>
                <td style="width:70%; text-align: left;" colspan="2">
                </td>
                <td style="width:30%; text-align: left;" colspan="2" >
                    <center>Dokter Pengirim
                    <br><br><br><br><br><br>
                   <?php echo $model->dokterpengirim->namaLengkap; ?><br />
                    </center>
                </td>
            </tr>
        </table>
        <div style="page-break-after: always;"></div>
        <table width="100%" class="borderclass" style="margin-top:5px">
            <tr class="borderclass">
                <td style="padding:5px">Kategori dan Pendamping Pasien Transfer</td>
            </tr>
            <tr>
                <td style="padding:10px">
                    <table width="100%" class="tablefont">
                        <tr>
                            <td width="30%" valign="top">
                                Derajat Pasien : <?php echo (!empty($modProsesTransfer->derajatpasien)?$modProsesTransfer->derajatpasien:"-"); ?>
                            </td>
                            <td width="40%" valign="top">
                                <table width="100%">
                                    <tr>
                                        <td>Nama Petugas Pendamping</td>
                                    </tr>
                                    <?php
                                        if(!empty($modProsesTransfer->prosestransferpasien_id)){
                                            $modPendamping = PegawaipendampingtransferpasienT::model()->findAllByAttributes(array('prosestransferpasien_id'=>$modProsesTransfer->prosestransferpasien_id));

                                            if(count($modPendamping) > 0){
                                                $pendampingvalue = "";
                                                $index= 1;
                                                foreach ($modPendamping as $i => $dataPendamping){
                                                    if($i > 0){
                                                        $pendampingvalue .= "<br />";
                                                    }
                                                    $pendampingvalue .= "<tr><td>".$index.". ".$dataPendamping->pegawai_nama."</td></tr>";
                                                    $index++;
                                                }
                                                echo $pendampingvalue;
                                            }
                                        }
                                    ?>
                                </table>
                            </td>
                            <td width="30%" valign="top">
                                Catatan : <?php echo (!empty($modProsesTransfer->catatanpendampingtransfer)?$modProsesTransfer->catatanpendampingtransfer:"-"); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table width="100%" class="borderclass" style="margin-top:5px">
            <tr class="borderclass">
                <td style="padding:5px" colspan="2">VI. Kondisi Pasien</td>
            </tr>
            <tr>
                <td width="50%" style="padding:10px" class="borderclass">
                    <table width="100%">
                        <tr>
                            <td><b>Sebelum Ditransfer</b></td>
                            <td width="75%" style="float: right;">Tanggal & Jam : <?php echo (!empty($modProsesTransfer->sebelumtransfer_tanggal)? MyFormatter::formatDateTimeForUser($modProsesTransfer->sebelumtransfer_tanggal):"-"); ?>	</td>
                        </tr>
                    </table>
                </td>
                <td width="50%" style="padding:10px" class="borderclass">
                    <table width="100%">
                        <tr>
                            <td><b>Setelah Ditransfer</b></td>
                            <td width="75%" style="float: right;">Tanggal & Jam : <?php echo (!empty($modProsesTransfer->setelahtransfer_tanggal)?MyFormatter::formatDateTimeForUser($modProsesTransfer->setelahtransfer_tanggal):"-"); ?>	</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="50%" style="padding:10px" class="borderclass">
                    <table width="100%" class="tablefont">
                        <tr>
                            <td width="120px">Keadaan Umum</td>
                            <td width="10px">:</td>
                            <td><?php echo (!empty($modProsesTransfer->sebelumtransfer_keadaanumum)?$modProsesTransfer->sebelumtransfer_keadaanumum:"-"); ?></td>
                        </tr>
                        <tr>
                            <td>Kesadaran</td>
                            <td>:</td>
                            <td><?php echo (!empty($modProsesTransfer->sebelumtransfer_kesadaran)?$modProsesTransfer->sebelumtransfer_kesadaran:"-"); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="font-weight: bold; color: black;">Pemeriksaan Tanda Vital</td>
                        </tr>
                        <tr>
                            <td style="padding-left:100px">Tensi</td>
                            <td>:</td>
                            <td> <?php echo (!empty($modProsesTransfer->sebelumtransfer_td_systolic)?$modProsesTransfer->sebelumtransfer_td_systolic:"-").'/ '.(!empty($modProsesTransfer->sebelumtransfer_td_diastolic)?$modProsesTransfer->sebelumtransfer_td_diastolic:"-"); ?> mmHg</td>
                        </tr>
                        <tr>
                            <td style="padding-left:100px">Suhu</td>
                            <td>:</td>
                            <td> <?php echo (!empty($modProsesTransfer->sebelumtransfer_suhutubuh)?$modProsesTransfer->sebelumtransfer_suhutubuh:"-"); ?> &#176 Celcius</td>
                        </tr>
                        <tr>
                            <td style="padding-left:100px">Nadi</td>
                            <td>:</td>
                            <td> <?php echo (!empty($modProsesTransfer->sebelumtransfer_nadi)?$modProsesTransfer->sebelumtransfer_nadi:"-"); ?> x/menit </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; color: black;">Skor EWS</td>
                            <td>:</td>
                            <td> <?php echo (!empty($modProsesTransfer->sebelumtransfer_skorews)?$modProsesTransfer->sebelumtransfer_skorews:"-").' '.(!empty($modProsesTransfer->sebelumtransfer_klasifikasi_skorews)?$modProsesTransfer->sebelumtransfer_klasifikasi_skorews:"-"); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="font-weight: bold; color: black;">Catatan Penting</td>
                        </tr>
                        <tr>
                            <td colspan="2"> <?php echo (!empty($modProsesTransfer->sebelumtransfer_catatanpenting)?$modProsesTransfer->sebelumtransfer_catatanpenting:"-"); ?></td>
                        </tr>
                    </table>
                </td>
                <td width="50%" style="padding:10px">
                    <table width="100%" class="tablefont">
                        <tr>
                            <td width="120px">Keadaan Umum</td>
                            <td width="10px">:</td>
                            <td><?php echo (!empty($modProsesTransfer->setelahtransfer_keadaanumum)?$modProsesTransfer->setelahtransfer_keadaanumum:"-"); ?></td>
                        </tr>
                        <tr>
                            <td>Kesadaran</td>
                            <td>:</td>
                            <td><?php echo (!empty($modProsesTransfer->setelahtransfer_kesadaran)?$modProsesTransfer->setelahtransfer_kesadaran:"-"); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="font-weight: bold; color: black;">Pemeriksaan Tanda Vital</td>
                        </tr>
                        <tr>
                            <td style="padding-left:100px">Tensi</td>
                            <td>:</td>
                            <td> <?php echo (!empty($modProsesTransfer->setelahtransfer_td_systolic)?$modProsesTransfer->setelahtransfer_td_systolic:"-").'/ '.(!empty($modProsesTransfer->setelahtransfer_td_diastolic)?$modProsesTransfer->setelahtransfer_td_diastolic:"-"); ?> mmHg</td>
                        </tr>
                        <tr>
                            <td style="padding-left:100px">Suhu</td>
                            <td>:</td>
                            <td> <?php echo (!empty($modProsesTransfer->setelahtransfer_suhutubuh)?$modProsesTransfer->setelahtransfer_suhutubuh:"-"); ?> &#176 Celcius</td>
                        </tr>
                        <tr>
                            <td style="padding-left:100px">Nadi</td>
                            <td>:</td>
                            <td> <?php echo (!empty($modProsesTransfer->setelahtransfer_nadi)?$modProsesTransfer->setelahtransfer_nadi:"-"); ?> x/menit </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; color: black;">Skor EWS</td>
                            <td>:</td>
                            <td> <?php echo (!empty($modProsesTransfer->setelahtransfer_skorews)?$modProsesTransfer->setelahtransfer_skorews:"-").' '.(!empty($modProsesTransfer->setelahtransfer_klasifikasi_skorews)?$modProsesTransfer->setelahtransfer_klasifikasi_skorews:"-"); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="font-weight: bold; color: black;">Catatan Penting</td>
                        </tr>
                        <tr>
                            <td colspan="2"> <?php echo (isset($modProsesTransfer->setelahtransfer_catatanpenting)? $modProsesTransfer->setelahtransfer_catatanpenting: ""); ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <p style="font-weight: bold; color: black">Catatan Penting: Perkembangan pasien selama proses rujukan (dalam perjalanan transportasi)</p>
        <br />
        <table width="100%">
            <tr>
                <td style="width:50%; text-align: left;" colspan="2">
                     <center>Petugas yang menyerahkan pasien
                    <br><br><br><br><br><br>
                   <?php echo (isset($modProsesTransfer->sebelumtransferpegawaiygmenyerahkan)? $modProsesTransfer->sebelumtransferpegawaiygmenyerahkan->namaLengkap:""); ?><br />
                    </center>
                </td>
                <td style="width:50%; text-align: left;" colspan="2" >
                    <center>Petugas yang menerima pasien
                    <br><br><br><br><br><br>
                   <?php echo (isset($modProsesTransfer->setelahtransferpegawaiygmenerima)? $modProsesTransfer->setelahtransferpegawaiygmenerima->namaLengkap: ""); ?><br />
                    </center>
                </td>
            </tr>
        </table>
            </td>
        </tr>
        </div>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="footerclass">2019-2022</div>
