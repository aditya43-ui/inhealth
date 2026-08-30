<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());?>
<table table width="100%">
                        <tr>
                            <td style="width: 40%" valign="top">
                                <table>
                                    <tr>
                                        <td width="30%" align="center" class="bordertopclass borderbottomclass borderleftclass">
                                            <div style="padding:5px"><img src="<?php echo Params::urlProfilRSDirectory() . $modProfilRs->logo_rumahsakit ?> " style="height: 100px; width: 100px"/></div>
                                        </td>
                                        <td width="1%" class="bordertopclass borderbottomclass">
                                        </td>
                                        <td  class="bordertopclass borderrightclass borderbottomclass">
                                            <font style="font-size:12px;"><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></font><br><br>
                                            <font style="font-size:12px;"><?php echo ucwords($modProfilRs->alamatlokasi_rumahsakit) . ' ' . ucwords(strtolower($modProfilRs->kecamatan->kecamatan_nama)) . ' ' . ucwords(strtolower($modProfilRs->kabupaten->kabupaten_nama)); ?></font><br>
                                            <font style="font-size:12px;">Phone. <?php echo $modProfilRs->no_telp_profilrs; ?></font> <br>
                                            <font style="font-size:12px;">FAX : <?php echo $modProfilRs->no_faksimili; ?></font>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 25%" valign="bottom">
                            </td>
                            <td style="width: 35%;">
                                <table class="borderclass" style="float:right; width: 100%">
                                    <tr>
                                        <td style="" width="120px">Nama Pasien</td>
                                        <td style="" width="10px">:</td>
                                        <td style="">
                                            <?php echo $modPasien->nama_pasien; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="" width="120px">Tanggal Lahir</td>
                                        <td style="" width="10px">:</td>
                                        <td style="">
                                            <?php echo MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="" width="120px">Jenis Kelamin</td>
                                        <td style="" width="10px">:</td>
                                        <td style="">
                                            <?php echo $modPasien->jeniskelamin; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="" width="120px">No. RM</td>
                                        <td style="" width="10px">:</td>
                                        <td style="">
                                            <?php echo $modPasien->no_rekam_medik; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="" width="120px">Dokter DPJP</td>
                                        <td style="" width="10px">:</td>
                                        <td style="">
                                            <?php
                                            $dokter = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
                                            $nama = "";

                                            if (isset($dokter)) {
                                                $nama = $dokter->namaLengkap;
                                            }
                                            echo $nama;
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>