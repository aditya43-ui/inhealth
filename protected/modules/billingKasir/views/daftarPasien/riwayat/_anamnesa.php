<style>

    .anamnesa_content {
        width: 100%;
        border-collapse: collapse;
    }

    .anamnesa_border td, .anamnesa_border th {
        border: 1px solid black;
    }

    .anamnesa_content td, .anamnesa_content th {
        font-size: 8pt;
        vertical-align: top;
    }

    .anamnesis_judul {
        text-align: center;
        font-size: 8pt;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .header_pasien td {
        border: 1px solid black;
    }

    .header_pasien {
        border-collapse: collapse;
        margin-bottom: 10px;
    }

</style>
<table class="anamnesa_content header_pasien">
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


<div class="anamnesis_judul">ANMNESIS</div>
<?php
if (count((array)$modAnamnesa)>0){
    $loop = $modAnamnesa[0];
?>
<table class="anamnesa_content">
    <tr>
        <td>Tgl. Anamnesa</td>
        <td>:</td>
        <td><?php echo MyFormatter::formatDateTimeForUser($loop->tglanamnesis); ?></td>
    </tr>
    <tr>
        <td width="150">Perawat</td>
        <td width="10">:</td>
        <td><?php echo $loop->paramedis_nama ?? " - "; ?></td>
    </tr>
    <tr>
        <td>Keluhan Utama</td>
        <td>:</td>
        <td><?php echo $loop->keluhanutama ?? " - "; ?></td>
    </tr>
    <tr>
        <td>Keluhan Tambahan</td>
        <td>:</td>
        <td><?php echo $loop->keluhantambahan ?? " - "; ?></td>
    </tr>
    <tr>
        <td>Riwayat Perjalanan Penyakit Pasien</td>
        <td>:</td>
        <td><?php echo $loop->riwayatperjalananpasien ?? " - "; ?></td>
    </tr>
    <tr>
        <td>Lama Sakit</td>
        <td>:</td>
        <td><?php echo $loop->lamasakit ?? " - "; ?></td>
    </tr>
    <tr>
        <td>Riwayat Penyakit Terdahulu</td>
        <td>:</td>
        <td><?php echo $loop->riwayatpenyakitterdahulu ?? " - "; ?></td>
    </tr>
    <tr>
        <td>Riwayat Penyakit Keluarga</td>
        <td>:</td>
        <td><?php echo $loop->riwayatpenyakitkeluarga ?? " - "; ?></td>
    </tr>
    <tr>
        <td>Riwayat Alergi Obat</td>
        <td>:</td>
        <td><?php echo $loop->riwayatalergiobat ?? " - "; ?></td>
    </tr>
    <tr>
        <td>Pengobatan yang sudah Dilakukan</td>
        <td>:</td>
        <td><?php echo $loop->pengobatanygsudahdilakukan ?? " - "; ?></td>
    </tr>
    <tr>
        <td>Riwayat Alergi Makanan</td>
        <td>:</td>
        <td><?php echo $loop->riwayatmakanan ?? " - "; ?></td>
    </tr>
</table>
<?php
} ?>
<hr />

