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
        <td>: <?= $viralload->no_lab ?></td>
        <td>&emsp;</td>
        <td style="width: 20%;">Tanggal Terima</td>
        <td>: <?= MyFormatter::formatDateTimeForUser($viralload->tgl_pemeriksaan) ?></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>: <?= $modPasien->nama_pasien ?></td>
        <td>&emsp;</td>
        <td>Tanggal MRS</td>
        <td>: <?= MyFormatter::formatDateTimeForUser($viralload->tgl_pemeriksaan) ?></td>
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
        <td>: <?= $viralload->pegawai->namaLengkap ?></td>
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
        <td>: <?= isset($viralload->daftartindakan->pemeriksaanlab_id) ? $viralload->daftartindakan->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_id : '' ?></td>
    </tr>
</table>
<br>
<center>
    <hr>
</center><br>
<div class="content-judul2">
    <div>
    <table class="table table-stripped table-bordered">
                    <thead>
                        <tr>
                            <th>No. </th>
                            <th>Parameter</th>
                            <th>Hasil</th>
                            <th>Satuan</th>
                            <th>Nilai Rujukan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: center;">1.</td>
                            <td style="text-align: center;">PCR-RNA HIV</td>
                            <td><?php echo $viralload->hasil_pcr_vl; ?></td>
                            <td style="text-align: center;">copies/mL</td>
                            <td style="text-align: center;">40-10.000.000</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">2.</td>
                            <td style="text-align: center;">LOG</td>
                            <td><?php echo $viralload->hasil_log_vl; ?></td>
                            <td style="text-align: center;">LOG</td>
                            <td style="text-align: center;">1.6-7</td>
                        </tr>
                    </tbody>
                </table>
    </div>
</div><br>
<br>
<table style="width: 100%; margin: 0 20px;" id="tbl-ttd">
    <tbody>
        <tr>
            <td style="text-align: center;"></td>
            <td style="text-align: center; width: 50%;"></td>
            <td style="text-align: center;">Malang, <?php echo date('d/m/Y', strtotime($viralload->tgl_pemeriksaan))?>
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
            <td style="text-align: center; font-weight: bold;"><?php echo $viralload->perawat->namaLengkap ?? '' ?></td>
            <td style="text-align: center;"></td>
            <td style="text-align: center; font-weight: bold;"><u><?php echo $viralload->pegawai->namaLengkap ?></u></td>
        </tr>
        <tr>
            <td style="text-align: center;"></u></td>
            <td style="text-align: center;"></td>
            <td style="text-align: center; font-weight: bold;">NIP. <?php echo $viralload->pegawai->nomorindukpegawai ?></td>
        </tr>
    </tbody>
</table>