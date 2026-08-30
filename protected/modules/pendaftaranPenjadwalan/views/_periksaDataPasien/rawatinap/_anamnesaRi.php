
<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 8pt !important;
        height: 24px;
        padding-left:10px;
    }
    body{
        width: 21.7cm;
    }
    .content td{
        height: 48px;
    }
</style>

<table width="100%" border="1">
    <tr>
        <td style="width:20%">SMF</td>
        <td style="width:30%"><?php echo $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama;  ?></td>
        <td style="width:20%">NO. Rekam Medik</td>
        <td style="width:30%"><?php echo $modPasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Nama</td>
        <td style="width:30%"><?php echo $modPasien->nama_pasien; ?></td>
        <td style="width:20%">Tgl. Lahir / UMUR</td>
        <td style="width:30%"><?php echo MyFormatter::formatDateTimeId($modPasien->tanggal_lahir); ?> / <?php echo CustomFunction::hitungUmur($modPasien->tanggal_lahir); ?></td>
    </tr>
    <tr>
        <td style="width:20%">Jenis Kelamin</td>
        <td style="width:30%"><?php echo $modPasien->jeniskelamin; ?></td>
        <td style="width:20%">No. Pendaftaran</td>
        <td style="width:30%"><?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
</table>
<table width="100%" class="content" style="border: none;">
    <tr>
        <td align="center" valign="middle" colspan="2" style="font-weight:bold">
            <h3>ANAMNESIS</h3>
        </td>
    </tr>
    <tr>
        <td style="width:30%">Keluhan Utama</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->keluhanutama)?$modAnamnesa->keluhanutama:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Keluhan Tambahan</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->keluhantambahan)?$modAnamnesa->keluhantambahan:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Riwayat Perjalanan Penyakit Pasien</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->riwayatperjalananpasien)?$modAnamnesa->riwayatperjalananpasien:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Lama sakit</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->lamasakit)?$modAnamnesa->lamasakit:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Riwayat Penyakit Terdahulu</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->riwayatpenyakitterdahulu)?$modAnamnesa->riwayatpenyakitterdahulu:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Riwayat Penyakit Keluarga</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->riwayatpenyakitkeluarga)?$modAnamnesa->riwayatpenyakitkeluarga:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Riwayat Alergi Obat</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->riwayatalergiobat)?$modAnamnesa->riwayatalergiobat:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Pengobatan yang sudah dilakukan</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->pengobatanygsudahdilakukan)?$modAnamnesa->pengobatanygsudahdilakukan:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Riwayat Alergi Makanan</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->riwayatmakanan)?$modAnamnesa->riwayatmakanan:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Riwayat Kelahiran</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->riwayatkelahiran)?$modAnamnesa->riwayatkelahiran:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Riwayat Imunisasi</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->riwayatimunisasi)?$modAnamnesa->riwayatimunisasi:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%;height:86px">Keterangan</td>
        <td style="width:70%;height:86px"><?php echo isset($modAnamnesa->keterangananamesa)?$modAnamnesa->keterangananamesa:" - "; ?></td>
    </tr>
</table>
<br><br>
