<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<style>
    .tab_header > tbody > tr > td {
        border: 1px solid black;
        vertical-align: middle;
    }
</style>
<table width="100%" class="tab_header">
    <tbody>
        <tr>
            <td style="width: 300px" align="center">
                <img src="<?php echo Params::urlProfilRSDirectory() . $modProfilRs->logo_rumahsakit ?> " style="height: 80px;"/>
            </td>
            <td align="center">
                FORM SKRINNING PASIEN<br/>MPP
            </td>
            <td style="width: 250px;" valign="middle" align="center">
                <table width="100%">
                    <tr>
                        <td width="100">No. RM</td>
                        <td width="10">: </td>
                        <td><?php echo $modPasien->no_rekam_medik; ?></td>
                    </tr>
                    <tr>
                        <td>Nama Pasien</td>
                        <td>: </td>
                        <td><?php echo $modPasien->nama_pasien; ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td>: </td>
                        <td><?php echo MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir); ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>: </td>
                        <td><?php echo $modPasien->jeniskelamin; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
