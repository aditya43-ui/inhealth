<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<div class="pull-right">
    FRM/55.1 Rev 01/RSBM
</div>
<div class="clear"></div>
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
                        <div>
                            <?php echo $modProfilRs->alamatlokasi_rumahsakit; ?>. Telp. <?php echo $modProfilRs->no_telp_profilrs; ?> Fax.  / <?php echo $modProfilRs->no_faksimili." - ".$modProfilRs->kabupaten->kabupaten_nama; ?>
                        </div>
                    </td>
                </tr>
            </table>
            
        </td>
        <td></td>
        <td width="300" style="border: 1px solid black; padding: 5px;">
            <table class="tab_header">
                <tr>
                    <td width="100">No. RM</td>
                    <td width="10">:</td>
                    <td><?php echo $daftar->pasien->no_rekam_medik; ?></td>
                </tr>
                <tr>
                    <td>Nama Pasien</td>
                    <td>:</td>
                    <td><?php echo $daftar->pasien->nama_pasien; ?></td>
                </tr>
                <tr>
                    <td>Tanggal Lahir</td>
                    <td>:</td>
                    <td><?php echo MyFormatter::formatDateTimeForUser($daftar->pasien->tanggal_lahir); ?></td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <td><?php echo $daftar->pasien->jeniskelamin; ?></td>
                </tr>
            </table>
            
        </td>
    </tr>
</table>
<br/>

<div style="text-align: center">
    <h2><?php echo $judulLaporan; ?></h2>
</div>
<br/>
<br/>