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
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
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
        <td>No. Antrian</td>
        <td>:</td>
        <td><b><?php echo $modPendaftaran->ruangan->ruangan_singkatan; ?>-<?php echo $modPendaftaran->no_urutantri; ?></b></td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td>
        <td>:</td>
        <td><b><?php echo $modPendaftaran->no_pendaftaran; ?></b></td>
    </tr>
    <tr>
        <td>Tgl. Pendaftaran</td>
        <td>:</td>
        <td><b><?php echo MyFormatter::formatDateTimeId($modPendaftaran->tgl_pendaftaran); ?></b></td>
    </tr>
    <tr>
        <td>Perkiraan Pelayanan</td>
        <td>:</td>
        <td><b><?php echo MyFormatter::formatDateTimeId($modPendaftaran->tglakandilayani); ?></b></td>
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
        <td>Poliklinik Tujuan</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->ruangan->ruangan_nama; ?></td>
    </tr>
    <tr>
        <td colspan="3">_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _</td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td>
        <td>:</td>
        <td><b><?php echo $modPendaftaran->no_pendaftaran; ?></b></td>
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
        <td>Karcis</td>
        <td>:</td>
        <td><?php echo (isset($modTindakan->karcis->karcis_nama) ? $modTindakan->karcis->karcis_nama : "-"); ?></td>
    </tr>
    <tr>
        <td>Harga Karcis</td>
        <td>:</td>
        <td><?php echo (isset($modTindakan->tarif_satuan) ? $format->formatUang($modTindakan->tarif_satuan * $modTindakan->qty_tindakan) : "-")?></td>
    </tr>
    
</table><br>
<table style="width: 100%; border: none;">
    <tr>
        <td width="50%"></td>
        <td>Kasir</td>
    </tr>
    <tr height="60px" valign="bottom">
        <td></td>
        <td><?php echo $modPegawai->nama_pegawai; ?></td>
    </tr>
</table>
<!--<div style="border: 0 solid;margin-top: 10px;text-align:center;width:200px;">
    <img style="height: 64px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modPendaftaran->pendaftaran_id; ?>&is_text=">  
    <div class="barcode-label"><?php echo $modPendaftaran->pendaftaran_id; ?></div>
</div>-->