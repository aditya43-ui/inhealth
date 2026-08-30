<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 8pt !important;
    }
    body{
        width:7.9cm;
    }
</style>
<?php echo $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._headerPrint'); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td align="center" valig="middle" colspan="3">
            <b><?php echo $judul_print ?></b>
        </td>
    </tr>
     <tr>
        <td align="center" valig="middle" colspan="3">
             Data Pasien
        </td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $modPasien->namadepan.$modPasien->nama_pasien.(!empty($modPasien->nama_bin) ? " (".$modPasien->nama_bin.")" : ""); ?></td>
    </tr>
    <tr>
        <td>No. Rekam Medis</td>
        <td>:</td>
        <td><?php echo $modPasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
<!--RND-3123  <tr>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td><?php echo $modPasien->jeniskelamin; ?></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td><?php echo $modPasien->alamat_pasien; ?></td>
    </tr>
    <tr>
        <td>Tanggal Lahir / Umur</td>
        <td>:</td>
        <td><?php echo $modPasien->tanggal_lahir; ?>/<?php echo $modPendaftaran->umur; ?></td>
    </tr>
    <tr>
        <td>Jenis Penjamin / Penjamin</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->carabayar->carabayar_nama; ?>/<?php echo $modPendaftaran->penjamin->penjamin_nama; ?></td>
    </tr>
    <tr>
        <td align="center" valig="middle" colspan="3">
            Perawatan <?php echo $modPendaftaran->instalasi->instalasi_nama; ?>
        </td>
    </tr>-->
    <tr>
        <td>Ruangan Tujuan<!--/ No. Antrian--></td>
        <td>:</td>
        <td><?php echo $modPendaftaran->ruangan->ruangan_nama; ?><!--/<?php echo $modPendaftaran->no_urutantri; ?>--></td>
    </tr>
<!--<tr>
        <td>Karcis</td>
        <td>:</td>
        <td><?php echo (isset($modTindakan->karcis->karcis_nama) ? $modTindakan->karcis->karcis_nama : "-"); ?></td>
    </tr>
    <tr>
        <td>Harga Karcis</td>
        <td>:</td>
        <td><?php echo (isset($modTindakan->tarif_satuan) ? $format->formatUang($modTindakan->tarif_satuan * $modTindakan->qty_tindakan) : "-")?></td>
    </tr>
    <tr>
        <td>Status Pembayaran Karcis</td>
        <td>:</td>
        <td>Belum Dibayar  Default dulu</td>
    </tr>
    <tr>
        <td>Dokter Pemeriksa</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->pegawai->NamaLengkap; ?></td>
    </tr>-->
</table>
<div style="border: 0 solid;margin-top: 10px;text-align:center;width:200px;">
    <img style="height: 64px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modPendaftaran->pendaftaran_id; ?>&is_text=">  
    <div class="barcode-label"><?php echo $modPendaftaran->pendaftaran_id; ?></div>
</div>