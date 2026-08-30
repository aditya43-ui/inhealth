<style>
    BODY, DIV, TABLE, TBODY, TFOOT, TR, TH, TD, P {
        font-family: "Arial" !important;
        font-size: 9.8px !important;
        font-weight: bold;
        color: black !important;
    }
</style>
<?php $umur = explode(" ", $modPendaftaran->umur); ?>
<?php $jeniskelamin = substr($modPendaftaran->pasien->jeniskelamin, 0, 1);
?>
<hr>
<div width="100%">
    <table>
        <tr>
            <td>Tanggal Keluar</td>
            <td>:</td>
            <td><?= date('d-m-Y H:i:s', strtotime($modPenyiapan->tglpenyiapandarah)) ?></td>
        </tr>
        <tr>
            <td>Nama Pasien</td>
            <td>:</td>
            <td><?= $modPendaftaran->pasien->nama_pasien ?></td>
        </tr>
        <tr>
            <td>No. MR Pasien</td>
            <td>:</td>
            <td><?= $modPendaftaran->pasien->no_rekam_medik ?></td>
        </tr>
        <tr>
            <td>Regno Pasien</td>
            <td>:</td>
            <td><?= $modPenunjang->labregno_lis ?></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td><barcode code="<?php echo $modPenunjang->labregno_lis; ?>" type="EAN128B" size="0.5" height="1"></barcode></td>
        </tr>
        <tr>
            <td>Tanggal Lahir / Usia</td>
            <td>:</td>
            <td><?= date('d-m-Y', strtotime($modPendaftaran->pasien->tanggal_lahir)) . ' (' . $umur[0] . ' Tahun)' ?></td>
        </tr>
        <tr>
            <td>Ruang</td>
            <td>:</td>
            <td><?= $modKirimUnit->createruangan->ruangan_nama ?></td>
        </tr>
        <tr>
            <td>Skrining Antibodi Pasien</td>
            <td>:</td>
            <td><?= $modPenyiapan->pemeriksaangoldar->screeningab ?></td>
        </tr>
        <tr>
            <td>Hasil Crossmatching</td>
            <td>:</td>
            <td><?= $modPenyiapan->pemeriksaangoldar->kesimpulan_goldar ?></td>
        </tr>
    </table>
</div>