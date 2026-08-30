<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>

<table width="100%">
    <tr>
    <td style="width: 30%" valign="top">
        <table>
            <tr>
                <td width="15%" align="center">
                    <div style="padding:5px"><img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> "/></div>
                </td>
            </tr>
        </table>
    </td>
    <td style="width: 30%">
        <table>
            <tr>
                <td align="center">
                    <h3><?php echo $header; ?></h3>
                </td>
            </tr>
        </table>
    </td>
    <td style="width: 40%;">
        <table class="borderclass" style="float:right; width: 50%">
            <tr>
                <td style="padding: 2px" width="80px">No. RM</td>
                <td style="padding: 2px" width="10px">:</td>
                <td style="padding: 2px">
                    <?php echo $modPasien->no_rekam_medik; ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 2px" width="80px">Nama</td>
                <td style="padding: 2px" width="10px">:</td>
                <td style="padding: 2px">
                    <?php echo $modPasien->nama_pasien; ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 2px" width="80px">Tgl. Lahir</td>
                <td style="padding: 2px" width="10px">:</td>
                <td style="padding: 2px">
                    <?php echo MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir); ?> 
                    / 
                    <?php 
                    if($modPasien->jeniskelamin == 'PEREMPUAN'){
                        echo 'P';
                    } else {
                        echo 'L';
                    }
                    ?>
                </td>
            </tr>
        </table>
    </td>
    </tr>
</table>
