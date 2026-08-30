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
    border: 1px solid white !important;
    border-top: 1px solid white !important;
}

.table-a tr, .table-a td {
    border: 1px solid white !important;
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
<table style="width: 85%; margin-left: 100px; margin-top: 50px;">
    <tr>
        <td style="width: 20%;">No. Laboratorium</td>
        <td>: <?= $pewarnaan->no_lab ?></td>
        <td>&emsp;</td>
        <td style="width: 20%;">Tanggal Terima</td>
        <td>: <?= MyFormatter::formatDateTimeForUser($pewarnaan->tgl_pemeriksaan) ?></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>: <?= $modPasien->nama_pasien ?></td>
        <td>&emsp;</td>
        <td>Tanggal MRS</td>
        <td>: <?= MyFormatter::formatDateTimeForUser($pewarnaan->tgl_pemeriksaan) ?></td>
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
        <td>: <?= $pewarnaan->pegawai->namaLengkap ?></td>
    </tr>
    <tr>
        <td>Tanggal Lahir</td>
        <td>: <?= MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir) ?></td>
        <td>&emsp;</td>
        <td>Ruang Pengirim</td>
        <td>: <?= '' ?></td>
    </tr>
    <tr>
        <td>Tanggal Selesai Hasil</td>
        <td>: </td>
        <td>&emsp;</td>
        <td>Jenis Pemeriksaan</td>
        <td>: <?= isset($pewarnaan->daftartindakan->pemeriksaanlab_id) ? $pewarnaan->daftartindakan->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_id : '' ?></td>
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
            </thead>
            <tbody>
                <tr>
                    <td style="width: 30%; font-weight: bold;">PEWARNAAN GARAM</td>
                    <td><br></td>
                </tr>
                <tr>
                    <td style="width: 30%;">&emsp;&emsp;&emsp;SEL EPITEL</td>
                    <td><?= strtoupper($pewarnaan->sel_epitel_pewarnaan) ?><br></td>
                </tr>
                <tr>
                    <td style="">&emsp;&emsp;&emsp;SEL RADANG</td>
                    <td><?= strtoupper($pewarnaan->sel_radang_pewarnaan) ?><br></td>
                </tr>
                <tr>
                    <td style="">&emsp;&emsp;&emsp;SEL MIKROORGANISME</td>
                    <td><?= strtoupper($pewarnaan->mikroorganisme) ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">PEWARNAAN ZIEHL NIELSEN</td>
                    <td><?= strtoupper($pewarnaan->ziehlnielsen_pewarnaan) ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">PEWARNAAN KOH</td>
                    <td><?= strtoupper($pewarnaan->koh_pewarnaan) ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">PEWARNAAN NEISSER</td>
                    <td><?= strtoupper($pewarnaan->niesser_pewarnaan) ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">PEWARNAAN NEGATIF</td>
                    <td><?= strtoupper($pewarnaan->negatif_pewarnaan) ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">PEWARNAAN SPORA</td>
                    <td><?= strtoupper($pewarnaan->spora_pewarnaan) ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">PEWARNAAN GIEMSA</td>
                    <td><?= strtoupper($pewarnaan->giemsa_pewarnaan) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div><br>
<div class="content-judul2" style="margin-left: 50px;">
    <div class="judul2">EXPERTISE:&nbsp;&nbsp;<br></div>
    <div>
        &emsp;&emsp;<?php echo strip_tags($pewarnaan->saran_pewarnaan) ?>
    </div>
</div><br>
<table style="width: 100%; margin: 0 20px;" id="tbl-ttd">
    <tbody>
        <tr>
            <td style="text-align: center;"></td>
            <td style="text-align: center; width: 50%;"></td>
            <td style="text-align: center;">Malang, <?php echo date('d/m/Y', strtotime($pewarnaan->tgl_pemeriksaan))?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">ATLM</td>
            <td style="text-align: center;"></td>
            <td style="text-align: center;">Dokter Laboratorium,</td>
        </tr>
        <tr>
            <td style="text-align: center;"></td>
            <td style="text-align: center;"></td>
            <td style="text-align: center;">TTD ELEKTRONIK</td>
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
            <td style="text-align: center; font-weight: bold;"><?php echo $pewarnaan->perawat->namaLengkap ?? 
            '' ?></td>
            <td style="text-align: center;"></td>
            <td style="text-align: center; font-weight: bold;"><u><?php echo $pewarnaan->pegawai->namaLengkap ?></u></td>
        </tr>
        <tr>
            <td style="text-align: center;"></u></td>
            <td style="text-align: center;"></td>
            <td style="text-align: center; font-weight: bold;">NIP. <?php echo $pewarnaan->pegawai->nomorindukpegawai ?></td>
        </tr>
    </tbody>
</table>