<style>
    .header-border {
        border-bottom: 1px solid black;
    }
</style>


<?php

$is_admisi = false;

if (!empty($admisi)) {
    $is_admisi = true;

    $daftar = date('Y-m-d', strtotime($modPendaftaran->tgl_pendaftaran));
    $pulang = empty($admisi->tglpulang) ? $admisi->rencanapulang : $admisi->tglpulang;

    $vpulang = date('Y-m-d', strtotime($pulang));

    $tgl_daftar = MyFormatter::formatDateTimeForUser($daftar);
    $tgl_pulang = MyFormatter::formatDateTimeForUser($vpulang);

    $val_daftar = strtotime($daftar);
    $val_pulang = strtotime($vpulang);

    $res = (($val_pulang - $val_daftar)/ (3600 * 24)) + 1;


    $str = $tgl_daftar." - ".$tgl_pulang;
}

?>

<?php
if (!empty($modPendaftaran->pasienadmisi_id)) {
    $kamarruangan = KamarruanganM::model()->findByPk($masukkamar->kamarruangan_id);
}
?>
<table width="100%">
  <tr>
    <td width="50%">
      <table width="100%">
        <tr>
          <td width="150px">Total Biaya Pelayanan</td>
          <td width="5px">:</td>
          <td>
            Rp. <?php echo MyFormatter::formatNumberForPrint($grand_totals, 2); ?>
          </td>
        </tr>
        <tr>
          <td>Terbilang</td>
          <td>:</td>
          <td>
            <?php echo $subtotalkotor==0?"NOL RUPIAH":strtoupper(MyFormatter::formatNumberTerbilang(MyFormatter::formatNumberForPrint($grand_totals, 2)))." RUPIAH"; ?>
          </td>
        </tr>
      </table>
    </td>
    <td width="50%">
      <table width="100%">
        <tr>
          <td width="150px">Jenis Penjamin</td>
          <td width="5px">:</td>
          <td>
            <?php echo (isset($admisi)? (isset($admisi->carabayar) ? $admisi->carabayar->carabayar_nama: ""): (isset($modPendaftaran->carabayar)? $modPendaftaran->carabayar->carabayar_nama: "")); ?>
          </td>
        </tr>
        <tr>
          <td>Penjamin</td>
          <td>:</td>
          <td>
            <?php echo (isset($admisi)? (isset($admisi->penjamin) ? $admisi->penjamin->penjamin_nama: ""): (isset($modPendaftaran->penjamin)? $modPendaftaran->penjamin->penjamin_nama: "")); ?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<div style="border-bottom-style: solid; border-bottom-width: thin; margin-top: 10px; margin-bottom: 10px"></div>
<table width="100%">
  <tr>
    <td width="50%">
      <table width="100%">
        <tr>
          <td width="150px">Tgl. Pendaftaran</td>
          <td width="5px">:</td>
          <td>
            <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?>
          </td>
        </tr>
        <tr>
          <td>No. Pendaftaran</td>
          <td>:</td>
          <td>
            <?php echo $modPendaftaran->no_pendaftaran; ?>
          </td>
        </tr>
        <tr>
          <td>No. Rekam Medik</td>
          <td>:</td>
          <td>
            <?php echo $pasien->no_rekam_medik; ?>
          </td>
        </tr>
        <tr>
          <td>Ruangan</td>
          <td>:</td>
          <td>
            <?php echo empty($modPendaftaran->pasienadmisi_id)?$modPendaftaran->ruangan->ruangan_nama:$admisi->ruangan->ruangan_nama; ?>
          </td>
        </tr>
      </table>
    </td>
    <td width="50%">
      <table width="100%">
        <tr>
          <td width="150px">Nama Pasien</td>
          <td width="5px">:</td>
          <td>
            <?php echo $pasien->namadepan.$pasien->nama_pasien; ?>
          </td>
        </tr>
        <tr>
          <td>Tanggal Lahir</td>
          <td>:</td>
          <td>
            <?php echo date('d / F /Y', strtotime($pasien->tanggal_lahir)); ?>
          </td>
        </tr>
        <tr>
          <td>Kelas Pelayanan</td>
          <td>:</td>
          <td>
            <?php echo (isset($admisi)? (isset($admisi->kelaspelayanan) ? $admisi->kelaspelayanan->kelaspelayanan_nama: ""): (isset($modPendaftaran->kelaspelayanan)? $modPendaftaran->kelaspelayanan->kelaspelayanan_nama: "")); ?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<!-- <table class="identitas" width="100%">
    <tr>
        <td>Jenis Penjamin</td><td>:</td><td><?php //echo $modPendaftaran->carabayar->carabayar_nama; ?></td>
        <?php /*<td>No Pembayaran</td><td>:</td><td><?php echo $modPembayaran->nopembayaran; ?></td> */ ?>
        <?php //if (!empty($modPendaftaran->pasienadmisi_id)): ?>
        <td nowrap>Kelas Pelayanan</td><td>:</td><td><?php //echo !empty($modPendaftaran->pasienadmisi_id)?$admisi->kelaspelayanan->kelaspelayanan_nama:$modPendaftaran->kelaspelayanan->kelaspelayanan_nama; ?></td>
        <?php //endif; ?>
    </tr>
    <tr>
        <td>Penjamin</td><td>:</td><td><?php //echo $modPendaftaran->penjamin->penjamin_nama; ?></td>
        <?php //if (!empty($asuransi) && !empty($modPendaftaran->pasienadmisi_id)): ?><td nowrap>Kelas Tanggungan</td><td>:</td><td><?php //echo $asuransi->kelastanggunganasuransi->kelaspelayanan_nama; ?></td><?php //endif; ?>
    </tr>
    <tr class="header-border">
        <td>Terbilang</td><td>:</td><td><?php //echo $subtotalkotor==0?"NOL RUPIAH":strtoupper(MyFormatter::formatNumberTerbilang($grand_totals))." RUPIAH"; ?></td>
        <td>Total Biaya</td><td>:</td><td><?php //echo MyFormatter::formatNumberForPrint($grand_totals); ?></td>
    </tr>
    <tr>
        <td nowrap>No. Rekam Medik</td><td>:</td><td width="100%"><?php //echo $pasien->no_rekam_medik; ?></td>
        <td nowrap>Tgl. Pendaftaran</td><td>:</td><td nowrap><?php //echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?></td>
    </tr>
    <tr>
        <td>Nama Pasien</td><td>:</td><td nowrap><?php //echo $pasien->namadepan.$pasien->nama_pasien; ?></td>
        <td>No. Pendaftaran</td><td>:</td><td nowrap><?php //echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
    <tr>
        <!--<td>Umur / Tgl. Lahir</td><td>:</td><td nowrap><?php //echo $modPendaftaran->umur." / ".MyFormatter::formatDateTimeForUser($pasien->tanggal_lahir); ?></td>-->
        <!-- <td>Tanggal Lahir</td><td>:</td><td nowrap><?php //echo date('d / F /Y', strtotime($pasien->tanggal_lahir)); ?></td>
        <td>Ruangan</td><td>:</td><td nowrap><?php //echo empty($modPendaftaran->pasienadmisi_id)?$modPendaftaran->ruangan->ruangan_nama:$admisi->kelaspelayanan->kelaspelayanan_nama; ?></td> -->
    <!-- </tr> -->
    <?php //if (!empty($admisi)): ?>

    <?php


        //if ($admisi->penjamin_id == Params::PENJAMIN_ID_UMUM):

        ?>
    <!-- <tr>
        <td>Alamat</td><td>:</td><td nowrap><?php //echo $pasien->alamat_pasien; ?></td>
        <td>Dokter</td><td>:</td><td nowrap><?php //echo empty($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->pegawai->namaLengkap : $admisi->pegawai->namaLengkap; ?></td>
    </tr> -->


    <?php //else : ?>
    <!-- <tr>
        <td>Alamat</td><td>:</td><td nowrap><?php //echo $pasien->alamat_pasien; ?></td>
        <td>Tgl Masuk</td><td>:</td><td nowrap><?php //echo $tgl_daftar; ?></td>
    </tr>
    <tr>
        <td>Dokter</td><td>:</td><td nowrap><?php //echo empty($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->pegawai->namaLengkap : $admisi->pegawai->namaLengkap; ?></td>
    </tr> -->
    <?php //endif; ?>


    <?php //endif; ?>
<!-- </table> --> 
