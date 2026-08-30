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
        <td><?php echo $modPasien->namadepan.$modPasien->nama_pasien.$modPasien->nama_bin; ?></td>
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
        <td>Tanggal Lahir / Umur</td>
        <td>:</td>
        <td><?php echo $modPasien->tanggal_lahir; ?></td>
    </tr>
    <tr>
        <td>Ruangan</td>
        <td>:</td>
        <td><?php echo $modJanjiPoli->ruangan->ruangan_nama; ?><?php echo (isset($modPendaftaran->no_urutantri) ? "/".$modPendaftaran->no_urutantri : ""); ?></td>
    </tr>
    <tr>
        <td>Dokter</td>
        <td>:</td>
        <td><?php echo (isset($modJanjiPoli->pegawai->nama_pegawai) ? $modJanjiPoli->pegawai->nama_pegawai : "-"); ?></td>
    </tr>
     <tr>
        <td>Tanggal Buat Janji</td>
        <td>:</td>
        <td><?php echo $modJanjiPoli->tglbuatjanji ?></td>
    </tr>
     <tr>
        <td>Tanggal Janji Ketemu/Hari</td>
        <td>:</td>
        <td><?php echo $modJanjiPoli->tgljadwal ?>/<?php echo $modJanjiPoli->harijadwal ?></td>
    </tr>
</table>