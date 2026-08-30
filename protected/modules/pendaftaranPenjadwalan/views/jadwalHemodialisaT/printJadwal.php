<?php 
echo $this->renderPartial('application.views.headerReport.headerHemodialisa',array('judulLaporan'=>'PERMINTAAN JADWAL HD RUTIN', 'model' => $model)); 
?>

<style>
    .ttd {
        text-align: center;
    }
    .ketentuan p {
        font-weight: bold;
    }
    .ketentuan {
        margin-top: -5px;
    }
</style>
<table class="bio">
    <tr>
        <td>NAMA</td>
        <td>:</td>
        <td><?= $model->pasienrl->nama_pasien ?></td>
    </tr>
    <tr>
        <td>HARI / TANGGAL</td>
        <td>:</td>
        <td><?= $model->jadwalhemodialisa_hari ?>, <?= MyFormatter::formatDateTimeForUser($model->jadwalhemodialisa_tgl_ke) ?></td>
    </tr>
    <tr>
        <td>SHIFT / JAM</td>
        <td>:</td>
        <td><?= $model->shift->shift_nama ?> / <?= $model->shift->shift_jamawal ?>-<?= $model->shift->shift_jamakhir ?></td>
    </tr>
    <tr>
        <td>TELEPON/HP</td>
        <td>:</td>
        <td><?= $model->pasienrl->no_telepon_pasien ?? '-' ?> / <?= $model->pasienrl->no_mobile_pasien ?? '-' ?></td>
    </tr>
    <tr>
        <td>KETERNAGAN LAIN</td>
        <td>:</td>
        <td> BILA BERHALANGAN HD / CUCI DARAH PADA HARI YANG DIJADWALKAN MOHON KONFIRMASI PALING LAMBAT 1 HARI SEBELUMNYA</td>
    </tr>
</table>

<div class="ketentuan">
    <p>PERSYARATAN YANG HARUS DIBAWA :</p>
    <ol>
        <li>SURAT KONTROL (HANYA KHUSUS AWAL HD/CUCI DARAH DARI RAWAT JALAN)</li>
        <li>FOTOKOPI RUJUKAN DARI FASKES 1 ATAU 2 (PUSKESMAS/RS)</li>
        <li>FOTOKOPI KARTU BPJS</li>
        <li>FOTOKOPI KARTU BEROBAT</li>
    </ol>

    <p>KEWAJIBAN DAN TATA TERTIB</p>
    <ol>
        <li>) Wajib mengurus SPJ (Surat Jaminan Pelayanan) Berupa  SEP dan Case Mix ke Admin HD</li>
        <li>) 2.1 Surat Kontrol hanya berlaku untuk 1x tindakan HD/Cuci darah dan belum pernah digunakan ke poli lain <br>
            2.2 Untuk HD/Cuci Darah selanjutnya wajib buat rujukan dari puskesmas/RS Faskes 1, Faskes 2 ditujukan kepada GINJAL HIPE HEMODIALISA RSUD Dr. Saiful Anwar Malang
        </li>
        <li>) Wajib memakai masker baik penunggu maupun pasien</li>
        <li>) Penununggu pasien 1 orang atau maksimal 2 orang apabila ada keterbatasan khusus dengan ijin petugas HD</li>
        <li>) Bila ada hal-hal lain yang kurang dipahami mohon minta penjelasan petugas HD atau administrasi "WAJIB MEMBERIKAN NO. TELP/HP KHUSUS PASIEN PERTAMA RAWAT JALAN"</li>
    </ol>

    <p>*KARTU INI HARAP DIBAWA SETIAP KALI CUCI DARAH</p>
</div>

<table width="100%" class="ttd">
    <tr>
        <td width="70%"></td>
        <td>
            Petugas Hemodialisa
        </td>
    </tr>
    <tr>
        <td></td>
        <td style="padding: 20px;">&nbsp;</td>
    </tr>
    <tr>
        <td></td>
        <td><?= $model->mengetahui->pegawai->namaLengkap ?></td>
    </tr>
</table>