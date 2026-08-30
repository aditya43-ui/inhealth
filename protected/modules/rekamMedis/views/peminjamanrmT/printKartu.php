<style>
    table {

        margin-left: auto;
        margin-right: auto;
    }

    .box {
        width: 355px;
    }
</style>

<table>
    <tr>
        <td colspan="3">
            <table>
                <tr>
                    <td>
                        <?php echo $this->renderPartial('application.views.headerReport.headerDefault'); ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" valig="middle" colspan="3">
            <b><?php echo $judulLaporan ?></b>
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
        <td><?php echo $modPasien->namadepan . $modPasien->nama_pasien . $modPasien->nama_bin; ?></td>
    </tr>
    <tr>
        <td>No. Rekam Medis</td>
        <td>:</td>
        <td><?php echo $modPasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
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
        <td>Tanggal Lahir</td>
        <td>:</td>
        <td><?php echo $modPasien->tanggal_lahir; ?></td>
    </tr>
    <tr>
        <td>No. Urut Peminjaman</td>
        <td>:</td>
        <td><?php echo $modPinjam->nourut_pinjam; ?></td>
    </tr>
    <tr>
        <td>Tanggal Peminjaman</td>
        <td>:</td>
        <td><?php echo $modPinjam->tglpeminjamanrm; ?></td>
    </tr>
    <tr>
        <td>Tanggal Akan Dikembalikan</td>
        <td>:</td>
        <td><?php echo $modPinjam->tglakandikembalikan; ?></td>
    </tr>
    <tr>
        <td>Nama Peminjam</td>
        <td>:</td>
        <td><?php echo $modPinjam->namapeminjam; ?></td>
    </tr>
    <tr>
        <td>Untuk Kepentingan</td>
        <td>:</td>
        <td><?php echo $modPinjam->untukkepentingan; ?></td>
    </tr>
    <tr>
        <td>Keterangan Peminjaman</td>
        <td>:</td>
        <td><?php echo $modPinjam->keteranganpeminjaman; ?></td>
    </tr>
</table>