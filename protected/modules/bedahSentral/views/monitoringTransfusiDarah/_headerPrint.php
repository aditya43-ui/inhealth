<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<?php $konfig = KonfigsystemK::model()->find(); ?>
<div class="pull-right" style="font-weight: bold; color: black;">RM.PP.01.b REV 02</div>
<table width="100%" style="border-collapse: collapse;">
    <tr>
        <td width="300" style="border: 1px solid black; padding: 5px;">
            <table>
                <tr>
                    <td><img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " style="max-width: 80px; width:80px;"/></td>
                    <td align="left">
                        <div>
                            <b><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></b>
                        </div>
                        <div class="header_alamat">
                            <?php echo $konfig->alamatheadersurat; ?>
                        </div>
                    </td>
                </tr>
            </table>
            
        </td>
        <td></td>
        <td width="300" style="border: 1px solid black; padding: 5px;">
            <table>
                <tr>
                    <td width="100">No. RM</td>
                    <td width="10">:</td>
                    <td><?php echo $kunjungan->pasien->no_rekam_medik; ?></td>
                </tr>
                <tr>
                    <td>Nama Pasien</td>
                    <td>:</td>
                    <td><?php echo $kunjungan->pasien->nama_pasien; ?></td>
                </tr>
                <tr>
                    <td>Tanggal Lahir</td>
                    <td>:</td>
                    <td><?php echo MyFormatter::formatDateTimeForUser($kunjungan->pasien->tanggal_lahir); ?></td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <td><?php echo $kunjungan->pasien->jeniskelamin; ?></td>
                </tr>
                <tr>
                    <td>Dokter DPJP</td>
                    <td>:</td>
                    <td><?php echo $daftar->pegawai->namaLengkap; ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>

<div style="text-align: center">
    <h2><?php echo $judulLaporan; ?></h2>
</div>
<br>
<br>