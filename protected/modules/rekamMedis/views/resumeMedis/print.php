<style>
.barcode-label {
    margin-top: -20px;
    z-index: 1;
    text-align: center;
    letter-spacing: 10px;
}

td,
th {
    /* font-size: 11pt !important; */
    /* height: 24px;
        padding-left:10px; */
}

body {
    /* width: 21.7cm; */
}

.content td {
    height: 12px;
}

.diagnosa td {
    height: 50px;
}

.borderAllclass {
    border: 1px solid black;
}

.padding5 {
    padding: 5px;
}

.tablefont td,
.tablefont th {
    padding: 5px;
}

.header-resume table {
    margin-left: 10px;
    margin-right: 10px;
}

.identitas-pasien {
    margin-left: 200px;
    margin-right: 100px;
}

.main-content {
    margin-left: 10px;
    margin-right: 10px;
}

table tr,
table td {
    vertical-align: top;
}
</style>
<?php 
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$modulLogin = Yii::app()->user->getState('modul_id');
?>
<div class="header-resume">
    <table width="100%">
        <tr style="border-bottom: 1px solid black;">
            <td>
                <?php echo $modProfilRs->nama_rumahsakit; 
        
        // echo '<pre>'; var_dump($); die;
        ?><br>
                <?php echo $modProfilRs->alamatlokasi_rumahsakit; ?><br>
                <?php echo "Telp." . $modProfilRs->no_telp_profilrs; ?><br>
                <?php echo "Email : " . $modProfilRs->email; ?>
            </td>
            <td>
                <br><br>
                <?php echo "Dibuat Oleh: " . $modResume->pegawai->namaLengkap; ?><br>
                <?php echo "Tgl. Terbit : " . $modResume->tglresume; ?>
            </td>
        </tr>
    </table>
</div>

<div class="identitas-pasien">
    <table width="100%">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td><?php echo $modResume->pasien->nama_pasien; ?></td>
        </tr>
        <tr>
            <td>Tempat/Tanggal Lahir</td>
            <td>:</td>
            <td><?php echo $modResume->pasien->tempat_lahir . "," . MyFormatter::formatDateTimeForUser($modResume->pasien->tanggal_lahir); ?>
            </td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>
                <?php
        $jenisKelamin = ($modResume->pasien->jeniskelamin == Params::JENIS_KELAMIN_LAKI_LAKI) ? "L" : "P";
        echo $modResume->pasien->jeniskelamin . " (" . $jenisKelamin . ")";
        ?>
            </td>
        </tr>
        <tr>
            <td>No. RM</td>
            <td>:</td>
            <td><?php echo $modResume->pasien->no_rekam_medik; ?></td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td><?php echo $modResume->pasien->no_identitas_pasien; ?></td>
        </tr>
        <tr>
            <td>Ruang/Klinik</td>
            <td>:</td>
            <td>
                <?php
          if($modulLogin == Params::MODUL_ID_RD) {
            echo Yii::app()->user->getState('ruangan_nama');
          } else {
            echo $modPendaftaran->ruangan->ruangan_nama; 
          }
        ?>
            </td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->kelaspelayanan->kelaspelayanan_nama; ?></td>
        </tr>
        <tr>
            <td>DPJP</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->pegawai->namaLengkap; ?></td>
        </tr>
        <tr>
            <td>Penjamin</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->penjamin->penjamin_nama; ?></td>
        </tr>
        <tr>
            <td>No. Telepon</td>
            <td>:</td>
            <td><?php echo $modResume->pasien->no_mobile_pasien; ?></td>
        </tr>
    </table>
</div>
<div style="border-bottom: 1px solid black;">
</div>

<div class="main-content">
    <h2 style="font-size: 24px; text-align:center;"><u>RESUME MEDIS</u></h2>
    <p style="font-size: 20px; text-align:center;">Medical Discharge Summary</p>
    <p>(Diisi oleh Dokter Penanggung Jawab Pelayanan)</p>
    <div class="content-1">
        <table width="50%">
            <tr>
                <td>Tanggal Masuk</td>
                <td width="5%">:</td>
                <td><?php echo $modPendaftaran->tgl_pendaftaran; ?></td>
            </tr>
            <tr>
                <td>Tanggal Keluar</td>
                <td>:</td>
                <td><?php
            if (!empty($modPendaftaran->pasienpulang_id)) {
              echo $modPendaftaran->pasienpulang->tglpasienpulang;
            } else {
              echo $modPendaftaran->tglselesaiperiksa;
            }
            ?></td>
            </tr>
            <tr>
                <td>Diagnosa Masuk</td>
                <td>:</td>
                <td><?php echo $modPendaftaran->diagnosamasuk; ?></td>
            </tr>
            <tr>
                <td>Diagnosa Keluar (Utama)</td>
                <td>:</td>
                <td> <?php echo $modResumeMedisMorbiR->diagnosa_kode ?? ''  ?>
                    <?php echo $modResumeMedisMorbiR->diagnosa_nama ?? '' ?></td>
            </tr>
        </table>
        <table width="100%" border="1">
            <tr>
                <td>No.</td>
                <td>Diagnosis Lain/Komplikasi/Penyakit</td>
                <td>Kode ICD-10</td>
            </tr>
            <?php
      if (!empty($modResumeMedisMorbiRTambah)) {

        $no = 1;
        foreach ($modResumeMedisMorbiRTambah as $i => $items) {
          if ($items->kelompokdiagnosa_id == Params::KELOMPOKDIAGNOSA_TAMBAH) {
      ?>
            <tr>
                <td><?php echo $no++ ?></td>
                <td><?php echo $items->diagnosa_nama; ?></td>
                <td><?php echo $items->diagnosa_kode; ?></td>
            </tr>
            <?php
          }
        }
      } else {
        ?>
            <tr>
                <td>1</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>
<br>
<div style="border-bottom: 1px solid black;">
</div>
<div class="content-2">
    <h2 style="font-size: 24px;">ANAMNESIS</h2>
    <p>(Diisi oleh Dokter Penanggung Jawab Pelayanan)</p>
    <table width="100%">
        <tr>
            <td>Keluhan Utama</td>
            <td>:</td>
            <td><?php echo strip_tags($modResume->keluhanutama) ?></td>
        </tr>
        <tr>
            <td>Riwayat Penyakit</td>
            <td>:</td>
            <td><?php echo strip_tags($modResume->riwayatpenyakitterdahulu) ?></td>
        </tr>
        <tr>
            <td>Pemeriksaan Fisik & Keadaan Umum</td>
            <td>:</td>
            <td>
                <?= $modResume->anamnesa ?>
            </td>
        </tr>
    </table>
    <br>
    <h2 style="font-size: 24px;">PEMERIKSAAN PENUNJANG</h2>
    <table width="100%">
        <tr>
            <td>Pemeriksaan Penunjang</td>
            <td>:</td>
            <td><?php echo $modResume->pemeriksaanpenunjang ?></td>
        </tr>
    </table>
    <br>
    <h2 style="font-size: 24px;">TINDAKAN MEDIS</h2>
    <table width="100%" border="1">
        <tr>
            <td>No.</td>
            <td>Prosedur</td>
            <td>Kode ICD.9.CM</td>
        </tr>
        <?php
    if (!empty($modPasienmorbiditasIcdixNew)) {
      foreach ($modPasienmorbiditasIcdixNew as $i => $items) {
    ?>
        <tr>
            <td><?php echo $i + 1 ?></td>
            <td><?php echo $items->diagnosaicdix_nama; ?></td>
            <td><?php echo $items->diagnosaicdix_kode; ?></td>
        </tr>
        <?php

      }
    } else {
      ?>
        <tr>
            <td>1</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <?php } ?>
    </table>
    <br>
    <h2 style="font-size: 24px;">TINDAKAN TERAPI</h2>
    <?php echo $modResume->planningdanterapi ?>
    <p>DIET: </p>
    <p>ALERGI : <?php echo $modResume->riwayatalergi ?></p>
    <br>
    <p style="font-size: 20px;">KONDISI SAAT PULANG</p>
    <table>
        <tr>
            <td>Kesadaran</td>
            <td>:</td>
            <td>-</td>
        </tr>
        <tr>
            <td rowspan="5" style="vertical-align: top;">Tanda Vital</td>
            <td rowspan="5" style="vertical-align: top;">:</td>
            <td>
                <?= $modResume->tandavital ?>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>
        </tr>

    </table>

    <table>
        <tr>
            <td>KEADAAN KELUAR</td>
            <td>:</td>
            <td>
                <?php 
                    $caraKeluar = '';
                    if(!empty($modResume->pasienadmisi_id)) {
                        echo 'KRS';
                        if(!empty($modResume->pasienadmisi->pasienpulang_id)) {
                            $caraKeluar = $modResume->pasienadmisi->pasienpulang->carakeluar->carakeluar_nama ?? '';
                        } else {
                            $caraKeluar = $modResume->pasienadmisi->carakeluar->carakeluar_nama ?? '';
                        }
                    } else {
                        if(!empty($modPendaftaran->pasienpulang_id)) {
                            if(!empty($modPendaftaran->pasienpulang->carakeluar_id == Params::CARAKELUAR_ID_RAWATINAP)) {
                                echo 'MRS';
                            } else {
                                echo 'KRS';
                            }

                            $caraKeluar = $modPendaftaran->pasienpulang->carakeluar->carakeluar_nama ?? '';
                        }
                    }
                    
                ?>
            </td>
        </tr>
        <tr>
            <td>CARA KELUAR <br> <i>Patient discharge of hospital</i></td>
            <td>:</td>
            <td>
                <?= $caraKeluar ?>
            </td>
        </tr>
    </table>
    <br>

    <?php if($modResume->ismeninggal == true):?>
    <p><b>Diagnosa Kematian</b></p>
    <table width="100%" border="1" style="text-align: center ;">
        <tr>
            <td style="font-weight: bold; width: 15%;">No.</td>
            <td style="font-weight: bold;">Nama Diagnosa</td>
            <td style="font-weight: bold; width: 30%;">Kode ICD-X</td>
        </tr>
        <?php if(count($riwayatDiagnosaKematian) > 0) : ?>
        <?php foreach($riwayatDiagnosaKematian as $i => $val) { ?>
        <?php
            $diagnosa = DiagnosaM::model()->findByPk($val->diagnosa_id);    
        ?>
        <tr>
            <td><?= $i+1 ?></td>
            <td><?= $val->diagnosa_nama ?? '' ?></td>
            <td><?= $diagnosa->diagnosa_kode ?? '' ?></td>
        </tr>
        <?php } ?>
        <?php endif; ?>
    </table>
    <br>
    <?php endif;?>

    <p>(Diisi oleh Dokter Penanggung Jawab Pelayanan)</p>
    <p style="font-size: 20px;">OBAT YANG DIBERIKAN :</p>
    <table width="100%" border="1" style="text-align: center ;">
        <tr>
            <td rowspan="2">No.</td>
            <td rowspan="2">Nama Obat <br> <i>(List of drugs)</i> </td>
            <td rowspan="2">Jumlah <br> <i>(Quantity)</i></td>
            <td rowspan="2">Dosis & Frekuensi <br><i>(Dose)</i></td>
            <td rowspan="2">Cara Pemberian <br> <i>(Method)</i></td>
            <td colspan="2">Keterangan</td>
        </tr>
        <tr>
            <td>Selama Perawatan</td>
            <td>Saat Pulang</td>
        </tr>
        <?php
    if (!empty($modResumeMedisObat_r)) {
      foreach ($modResumeMedisObat_r as $i => $items) {
    ?>
        <tr>
            <td><?php echo $i + 1 ?></td>
            <td><?php echo $items->nama_obat; ?></td>
            <td><?php echo $items->qty; ?></td>
            <td><?php echo $items->dosis; ?></td>
            <td><?php echo $items->caraminum; ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <?php

      }
    } else {
      ?>
        <tr>
            <td>1</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <?php } ?>
    </table>
    <br>
    <?php
  $hide = '';
  if(!empty($modPasienPulang->carakeluar_id)) {
      if($modPasienPulang->carakeluar_id == Params::CARAKELUAR_ID_MENINGGAL) {
        $hide = 'hidden';
      }
  }
?>
    <div <?= $hide ?>>
        <p><i>(Diisi oleh Dokter Penanggung Jawab Pelayanan)</i></p>
        <table>
            <tr>
                <td rowspan="3">INSTRUKSI UNTUK TINDAK LANJUT <br> <i>(Follow up Instructions)</i></td>
                <td rowspan="3">Kontrol Ke <br> <i>Follow up Consultation to</i></td>
                <td>Fasyankes</td>
                <td>: <?php echo $modProfilRs->nama_rumahsakit; ?></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:
                    <?php 
            if(!empty($suratKeternaganR->tglkontrol)) {
              echo MyFormatter::formatDateTimeForUser($suratKeternaganR->tglkontrol);
            }
        ?>
                </td>
            </tr>
            <tr>
                <td>Klinik</td>
                <td>:
                    <?php 
            if(!empty($suratKeternaganR->ruangan)) {
              echo $suratKeternaganR->ruangan->ruangan_nama;
            }
        ?>
                </td>

            </tr>
            <tr>
                <td>Dalam Keadaan darurat dapat menghubungi <br> <i>In case of emergency contact</i></td>
                <td>IGD <br> <i>(Accident & Emergency Instalation)</i></td>
                <td>Telepon </td>
                <td>:</td>
            </tr>
        </table>
        <p>EDUKASI & RENCANA TINDAK LANJUT <i>(bila diperlukan)</i></p>
        <p><i>Follow up plan (if necessary)</i></p>
        <p>-</p>
    </div>
    <br>
    <table width="100%" style="margin-left: 100px; margin-right:100px">
        <tr>
            <td>Pasien/Penanggung Jawab <br> <i>Patient/Person in charge </i></td>
            <td>Dokter Penanggung Jawab Pelayanan <br><i>Attending Physician</i></td>
        </tr>
        <tr height="100px">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><?php echo $modResume->pasien->nama_pasien; ?></td>
            <td><?php echo $modResume->pegawai->namaLengkap; ?></td>
        </tr>
    </table>

</div>