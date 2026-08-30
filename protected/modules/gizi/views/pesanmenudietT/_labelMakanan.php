<style>
   table.a tr td {
      vertical-align: top;
   }

   table.a tr td label {
      font-size: 7pt;
   }

   table.a tr td {
      font-size: 7pt;
   }

   table tr td label {
      font-size: 7pt;
   }

   table tr td {
      font-size: 7pt;
   }

   #base_catatan {
      border-top: 1px solid black;
      padding-top: 2px;
   }

   #catatan {
      margin: 0;
   }

   #catatan li {
      font-size: 7pt;
   }

   @media (min-width:0px) and (max-width: 70px) {
      table {
         width: 100%;
         padding: 10px;
      }
      

   }
   @page {
        font-size: 7pt !important;
        margin: 0;
    }

    @media print {

        html,
        body {
            margin: 0;
            font-family: "Arial" !important;
            /* font-weight: bold; */
        }

        /* div.footer {
            position: fixed;
            bottom: 0;
        } */

        .page-break {
            display: block;
            page-break-before: always;
        }
    }
</style>
<?php
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT);
$konfig = KonfigsystemK::model()->find();
$path = Params::pathProfilRSDirectory() . $modProfilRs->logo_rumahsakit_2;
$kelas = "";



$res = "";
$ext = "png";

if (file_exists($path)) {
   $content = file_get_contents($path);
   $ext_data = pathinfo($path);

   if (!empty($ext_data) && is_array($ext_data) && !empty($ext_data)) {
      $ext = $ext_data['extension'];
   }

   $res = "data:image/" . $ext . ";base64," . base64_encode($content);
}
?>
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
<?php
    $jeniswaktu = !empty($val->jeniswaktu_id) ? $val->jeniswaktu->jeniswaktu_nama : '';
    $jenismakanan = !empty($val->jenismakanan_id) ? $val->jenismakanan->jenismakanan_nama : '';
    $jenismenudiet = !empty($val->menudiet->jenismenudiet) ? $val->menudiet->jenismenudiet->jenismenudiet_nama : '';
    $alatmakan = !empty($val->alatmakanan_id) ? $val->alatmakanan->alatmakanan_nama : '';
    if (!empty($val->pendaftaran->pasienadmisi_id)) {
        $cekPasienAdmisi = PasienadmisiT::model()->findByPk($val->pendaftaran->pasienadmisi_id);
        $cekMasukKamar = MasukkamarT::model()->findByAttributes(array('pasienadmisi_id' => $cekPasienAdmisi->pasienadmisi_id), array('order' => 'masukkamar_id DESC'));
        $ruangan = !empty($cekMasukKamar->ruangan->ruangan_nama) ? $cekMasukKamar->ruangan->ruangan_nama : '-';
        $kelas = !empty($cekMasukKamar->kelaspelayanan->kelaspelayanan_nama) ? $cekMasukKamar->kelaspelayanan->kelaspelayanan_nama : '-';
        $bed = !empty($cekMasukKamar->kamarruangan->kamarruangan_nobed) ? $cekMasukKamar->kamarruangan->kamarruangan_nobed : '-';
    } else {
        $ruangan = '-';
        $kelas = '-';
        $bed = '-';
    }
    $modPendaftaran = PendaftaranT::model()->findByPk($val['pendaftaran_id']);
    $modPasien = PasienM::model()->findByPk($val->pasien_id);
    $modRuangan = RuanganM::model()->findByPk($modPendaftaran->pasienadmisi->ruangan_id);
    $modJenis = JenisdietM::model()->findByPk($modPesan->jenisdiet_id);
    $modMenuDiet = MenuDietM::model()->findByPk($val->menudiet_id);
    $modJenisWaktu = JeniswaktuM::model()->findByPk($val->jeniswaktu_id);
    $modTipeDiet = TipeDietM::model()->findByAttributes(['tipediet_id' => $val->tipediet_id]);
    $tipediet = !empty($modTipeDiet) ? $modTipeDiet->tipediet_nama : '-';

    $loginVerif = LoginpemakaiK::model()->findByPk($modPesan->create_loginpemakai_id);
?>

   <?php /*
   <header style="margin-top: 1rem; padding-top: 0.5rem">
      <?php // echo $this->renderPartial('application.views.headerReport._headerEtiketPutih'); ?>
   </header>
   <hr>
   */ ?>
   <table width="100%" class="a" cellpadding="0" cellpadding="0">
      <tr>
         <td width="50">Tgl Diet</td>
         <td width="5">:</td>
         <td><?php echo !empty($modPesan->tglpesanmenu) ? date('d-m-Y', strtotime($modPesan->tglpesanmenu)) :"-";?></td>
      </tr>
      <tr>
         <td>Waktu Diet</td>
         <td>:</td>
         <td><?php echo $modJenisWaktu->jeniswaktu_nama ?? "-";?></td>
      </tr>
      <tr>
         <td>Ruangan</td>
         <td>:</td>
         <td><?php echo $modRuangan->ruangan_namalainnya . " - " . $modPendaftaran->pasienadmisi->kelaspelayanan->kelaspelayanan_nama; ?></td>
      </tr>
      <tr>
         <td>&nbsp;</td>
      </tr>
      <tr>
         <td colspan="3" style="border-bottom: 1px dotted black; text-align: center;">IDENTITAS PASIEN</td>
      </tr>
      <tr>
         <td>Nama</td>
         <td>:</td>
         <td><?php echo $modPasien->nama_pasien; ?></td>
      </tr>
      <tr>
         <td>Tgl. Lahir</td>
         <td>:</td>
         <td><?php echo MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir); ?></td>
      </tr>
      <tr>
         <td>No. RM</td>
         <td>:</td>
         <td><?php echo $modPasien->no_rekam_medik; ?></td>
      </tr>
      <tr>
         <td>&nbsp;</td>
      </tr>
      <tr>
         <td>Diet</td>
         <td>:</td>
         <td><?php echo $modJenis->jenisdiet_nama ?? "-"; ?></td>
      </tr>
      <tr>
         <td>Ket</td>
         <td>:</td>
         <td><?php
          
          if (!empty($modMenuDiet->menudiet_nama)) {
            $arr_menu = explode(",", $modMenuDiet->menudiet_nama);

            foreach ($arr_menu as $idx_menu => $val_menu) {
               $arr_menu[$idx_menu] = trim($val_menu);
            }

            echo implode("<br/>", $arr_menu);

          } else {
            echo "-";
          }
          
          // echo $modMenuDiet->menudiet_nama ?? "-"; 
          
          ?></td>
      </tr>
      <tr>
         <td>Petugas</td>
         <td>:</td>
         <td><?php echo $modPesan->nama_pemesan; ?></td>
      </tr>
      <tr>
         <td>Verifikasi</td>
         <td>:</td>
         <td>
            <?php 
               if(!empty($val->verifikasi_id)) {
                  echo $val->pegawaiverif->namaLengkap ?? "-"; 
               }
            ?>
         </td>
      </tr>

      <?php /*
      <tr>
         <td width='30%'>
            <label class='control-label'>Nama Pasien</label>
         </td>
         <td>:</td>
         <td width='67%'>
            <?php echo !empty($modPasien->nama_pasien) ? substr($modPasien->nama_pasien, 0, 25)  : '-'; ?>
      </tr>
      <tr>
         <td width='30%'>
            <label class='control-label'>No. RM</label>
         </td>
         <td>:</td>
         <td width='67%'> 
         <?php echo !empty($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : '-'; ?>
         </td>
      </tr>
      <?php //if ($jenispesanmenu != Params::JENISPESANMENU_PENDAMPING) { ?>
         <tr>
            <td width='30%'>
               <label class='control-label'>Tgl lahir</label>
            </td>
            <td>:</td>
            <td width='67%'><?php echo !empty($modPasien->tanggal_lahir) ? MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir) : '-'; ?> </td>
         </tr>
      <?php //} ?>
      <!-- <tr>
         <td width='30%'>
            <label class='control-label'>Kelas Pasien</label>
         </td>
         <td width='67%'>:  </td>
      </tr> -->
      <tr>
         <td width='30%'>
            <label class='control-label'>Ruangan</label>
         </td>
         <td>:</td>
         <td width='67%'><?php echo !empty($ruangan) ? $ruangan : '-'; ?> / <?php echo !empty($kelas) ? $kelas : '-'; ?> / <?php echo !empty($bed) ? $bed : '-'; ?></td>
      </tr>
      <tr>
         <td width='30%'>
            <label class='control-label'>Jenis Diet</label>
         </td>
         <td>:</td>
         <td width='67%'><?php echo !empty($modMenuDiet->menudiet_nama) ? $modMenuDiet->menudiet_nama : '-'; ?> </td>
      </tr>
      <tr>
         <td width='30%'>
            <label class='control-label'>Alergi</label>
         </td>
         <td>:</td>
         <td width='67%'><?php echo !empty($modPesan->adaalergimakanan) ? $modPesan->adaalergimakanan : '-'; ?> </td>
      </tr>
      <tr>
         <td width='30%'>
            <label class='control-label'>Bentuk Diet</label>
         </td>
         <td>:</td>
         <td width='67%'><?php echo !empty($tipediet) ? $tipediet : '-'; ?> </td>
      </tr>
      <tr>
         <td width='30%'>
            <label class='control-label'>Jam Makan</label>
         </td>
         <td>:</td>
         <td width='67%'><?php echo !empty($modJenisWaktu->jeniswaktu_nama) ? $modJenisWaktu->jeniswaktu_nama : '-'; ?> </td>
      </tr>
      */ ?>
   </table>
   <!-- <div id="base_catatan">
      <ul id="catatan">
         <li>MAKANAN DAN MINUMAN / SUSU HARAP SEGERA DIKONSUMSI MAKSIMAL 1 JAM SETELAH PENYAJIAN</li>
         <li>MOHON ALAT MAKANAN TIDAK DIKELUARKAN DARI RUANGAN. TERIMA KASIH.</li>
      </ul>
   </div> -->
   <?php //endforeach; ?>