<style>
hr {
    border: 1pt solid grey;
    text-align: center;
    width: 95%;
}

.judul {
    text-align: center;
    font-weight: bold;
    font-style: "Arial Narrow", Arial, sans-serif;
}

.judul2 {
    font-weight: bold;
    font-style: "Arial Narrow", Arial, sans-serif;
}

.content-judul2 {
    margin-left: 20px;
    font-style: "Arial Narrow", Arial, sans-serif;
}

#tbl-ttd tr,
#tbl-ttd td {
    line-height: 25px;
}

.table-a tr, .table-a th {
    border: 1px solid black !important;
    border-top: 1px solid black !important;
}

.table-a tr, .table-a td {
    border: 1px solid black !important;
    line-height: 30px;

}

</style>

<div>
    <div class="header">
        <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNewKabRS'); ?>
    </div>
</div>
<br>
<center>
    <hr>
</center><br>
<p>
<h3 class="judul"><u>HASIL PEMERIKSAAN MIKROBIOLOGI KLINIK</u></h3>
</p>
<table style="width: 90%; margin-left: 60px; margin-top: 50px;" class="table-stripped">
    <tr>
        <td style="width: 20%;">No. Laboratorium</td>
        <td>: <?= $cci->no_lab ?></td>
        <td>&emsp;</td>
        <td style="width: 20%;">Tanggal Terima</td>
        <td>: <?= MyFormatter::formatDateTimeForUser($cci->tgl_pemeriksaan) ?></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>: <?= $modPasien->nama_pasien ?></td>
        <td>&emsp;</td>
        <td>Tanggal MRS</td>
        <td>: <?= MyFormatter::formatDateTimeForUser($cci->tgl_pemeriksaan) ?></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>: <?= $modPasien->jeniskelamin ?></td>
        <td>&emsp;</td>
        <td>Nomor Rekam Medik</td>
        <td>: <?= $modPasien->no_rekam_medik ?></td>
    </tr>
    <tr>
        <td>Usia</td>
        <td>: <?= $modPasien->umurTahun . ' Tahun' ?></td>
        <td>&emsp;</td>
        <td>Dokter Pengirim</td>
        <td>: <?= $cci->pegawai->namaLengkap ?></td>
    </tr>
    <tr>
        <td>Tanggal Lahir</td>
        <td>: <?= MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir) ?></td>
        <td>&emsp;</td>
        <td>Ruang Pengirim</td>
        <td>: <?= $cci->pasienmasukpenunjang->pasienkirimkeunitlain->ruangan->ruangan_nama ?? '' ?></td>
    </tr>
    <tr>
        <td>Tanggal Selesai Hasil</td>
        <td>: <?= MyFormatter::formatDateTimeForUser($modKelompokcci->tgl_pemeriksaan) ?></td>
        <td>&emsp;</td>
        <td>Jenis Pemeriksaan</td>
        <td>: <?= isset($cci->tindakanpelayanan) ? $cci->tindakanpelayanan->jenispemeriksaanlab->jenispemeriksaanlab_nama : '' ?></td>
    </tr>
</table>
<br>
<center>
    <hr>
</center><br>
<div class="content-judul2">
    <div>
        <table style="margin-left: 20px; width: 95%;  border: 1px solid red;" class="table-a">
            <thead>
            <tr>
                <th style="font-size: 10.5pt; text-align: left;">JENIS PEMERIKSAAN</th>
                <th style="font-size: 10.5pt; text-align: left;">HASIL</th>
            </tr>
            <tr>
                <th style="font-size: 10.5pt; text-align: left;">CANDIDA COLONIZATION INDEX</th>
                <th style="font-size: 10.5pt; text-align: left;"></th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width: 30%;">&emsp;&emsp;&emsp;SPUTUM</td>
                    <td><?= strtoupper($cci->sputum) ?><br></td>
                </tr>
                <tr>
                    <td style="">&emsp;&emsp;&emsp;SWAB TENGGOROK</td>
                    <td><?= strtoupper($cci->swab_tenggorok) ?><br></td>
                </tr>
                <tr>
                    <td style="">&emsp;&emsp;&emsp;URINE</td>
                    <td><?= strtoupper($cci->urine) ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">SWAB PERINEUM/PERIANAL</td>
                    <td><?= strtoupper($cci->swab_perineum) ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">LAIN-LAN: .....</td>
                    <td><?= strtoupper($cci->cci_lain) ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">INTERPRESTASI: </td>
                    <td><?= strtoupper($cci->interprestasi) ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">EXPERTISE</td>
                    <td><?= strip_tags($cci->saran) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div><br>
<table style="width: 80%; margin: 0 100px;" id="tbl-ttd">
    <tbody>
        <tr>
            <td style="text-align: center;"></td>
            <td style="text-align: center; width: 50%;"></td>
            <td style="text-align: center;">Malang, <?php echo date('d/m/Y', strtotime($cci->tgl_pemeriksaan))?></td>
        </tr>
        <tr>
            <td style="text-align: center;">ATLM</td>
            <td style="text-align: center;"></td>
            <td style="text-align: center;">DPJP</td>
        </tr>
        <tr>
            <td style="text-align: center;">&emsp;</td>
            <td style="text-align: center;">&emsp;</td>
            <td style="text-align: center;">&emsp;</td>
        </tr>
        <tr>
            <td style="text-align: center;">&emsp;</td>
            <td style="text-align: center;">&emsp;</td>
            <td style="text-align: center;">&emsp;</td>
        </tr>
        <tr>
            <td style="text-align: center;">Ttd. elektronik</td>
            <td style="text-align: center;"></td>
            <td style="text-align: center;">Ttd. elektronik</td>
        </tr>
        <tr>
            <td style="text-align: center;"><?php echo $cci->perawat->namaLengkap ?? '' ?></td>
            <td style="text-align: center;"></td>
            <td style="text-align: center;"><?php echo isset($cci->pegawai) ? $cci->pegawai->namaLengkap : "-" ?></td>
        </tr>
    </tbody>
</table>