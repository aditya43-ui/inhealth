<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>


<style>
    
    body {
        font-size: 10px;
    }
    
    .tab_header > tbody > tr > td {
        padding: 5px;
    }
    
    .tab_header_border {
        border: 1px solid black;
    }
    
</style>

<table width="100%" class='tab_header'>
    <tbody>
        <tr>
            <td width="35%" class="tab_header_border">
                <table> 
                    <tr>
                        <td align="center">
                            <div style="padding:5px"><img src="<?php echo Params::urlProfilRSDirectory() . $modProfilRs->logo_rumahsakit ?> " style="height: 100px; width: 140px"/></div>
                        </td>
                        <td width="150">
                            <?php echo strtoupper($modProfilRs->nama_rumahsakit); ?><br><br>
                            <?php echo ucwords($modProfilRs->alamatlokasi_rumahsakit) . ' ' . ucwords(strtolower($modProfilRs->kecamatan->kecamatan_nama)) . ' ' . ucwords(strtolower($modProfilRs->kabupaten->kabupaten_nama)); ?><br>
                            Phone. <?php echo $modProfilRs->no_telp_profilrs; ?><br>
                            FAX : <?php echo $modProfilRs->no_faksimili; ?>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="30%">

            </td>
            <td width="35%" class="tab_header_border">
                <table>
                    <tr>
                        <td>Nama Pasien</td>
                        <td>:</td>
                        <td>
                            <?php echo $modPasien->nama_pasien; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td>:</td>
                        <td>
                            <?php echo MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>:</td>
                        <td>
                            <?php echo $modPasien->jeniskelamin; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>No. RM</td>
                        <td>:</td>
                        <td>
                            <?php echo $modPasien->no_rekam_medik; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Dokter DPJP</td>
                        <td>:</td>
                        <td>
                            <?php
                            $pegawai_id = $modPendaftaran->pegawai_id;
                            $ruangan_id = Yii::app()->user->getState("ruangan_id");

                            if (Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_IBS || Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_GIZI) {
                                $modPendaftaran = PasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => $ruangan_id));
                                $pegawai_id = $modPendaftaran->dokterasal_id;
                            } else if (Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RD) {
                                if (Yii::app()->user->getState("ruangan_id") == Params::RUANGAN_ID_VK) {
                                    $modPendaftaran = InfokunjunganpersalinanV::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => $ruangan_id));
                                    $pegawai_id = $modPendaftaran->pegawai_id;
                                }
                            } else if (Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RD) {
                                $modPasienAdmisi = PasienadmisiT::model()->findByAttributes(array('pasienadmisi_id' => $modPendaftaran->pasienadmisi_id));
                                $pegawai_id = $modPasienAdmisi->dokterpenerima_id;
                            }
                            $modpegawai = PegawaiM::model()->findByPk($pegawai_id);
                            echo (isset($modpegawai) ? $modpegawai->namaLengkap : "-");
                            ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
