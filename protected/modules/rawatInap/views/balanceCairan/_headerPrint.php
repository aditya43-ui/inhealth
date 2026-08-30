<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>

<table width="100%">
    <tbody>
        <tr>
            <td width="30%" align="center" class="borderclass padding5">
                <img src="<?php echo Params::urlProfilRSDirectory() . $modProfilRs->logo_rumahsakit ?> " style="height: 80px;"/>
            </td>
            <td width="30%" align="center" class="borderclass padding5">
              <b>REKAM ASUHAN KEPERAWATAN <br />
              OBSERVASI DAN BALANCE CAIRAN</b>
            </td>
            <td width="40%" valign="top" class="borderclass padding5">
                <table width="100%">
                    <tr>
                        <td width="150px">Nama Pasien</td>
                        <td width="5px">: </td>
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
                    <tr>
                        <td>No. RM</td>
                        <td>: </td>
                        <td><?php echo $modPasien->no_rekam_medik; ?></td>
                    </tr>
                    <tr>
                        <td>Ruangan</td>
                        <td>: </td>
                        <td>
                            <?php 
                                $ruangan = RuanganM::model()->findByPk($model->create_ruangan_id);
                                echo (!empty($ruangan)?$ruangan->ruangan_nama : ""); 
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Tanggal Pendaftaran</td>
                        <td>: </td>
                        <td><?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?></td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>: </td>
                        <td><?php echo $modPasien->no_identitas_pasien; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
