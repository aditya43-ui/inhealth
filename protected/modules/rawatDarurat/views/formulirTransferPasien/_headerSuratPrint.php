<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>

<table width="100%">
    <tr>
    <td style="width: 35%" valign="top">
        <table>
            <tr>
                <td width="25%" align="center" class="bordertopclass borderbottomclass borderleftclass">
                    <div style="padding:5px"><img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " style="height: 100px; width: 90px"/></div>
                </td>
                <td width="1%" class="bordertopclass borderbottomclass">
                </td>
                <td  class="bordertopclass borderrightclass borderbottomclass">
                    <font style="font-size:12px;"><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></font><br><br>
                     <font style="font-size:12px;"><?php echo ucwords($modProfilRs->alamatlokasi_rumahsakit). ' '. ucwords(strtolower($modProfilRs->kecamatan->kecamatan_nama)) . ' '.ucwords(strtolower($modProfilRs->kabupaten->kabupaten_nama)); ?></font><br>
                    <font style="font-size:12px;">Phone. <?php echo $modProfilRs->no_telp_profilrs;?></font> <br>
                <font style="font-size:12px;">FAX : <?php echo $modProfilRs->no_faksimili; ?></font>
                </td>
            </tr>
        </table>
    </td>
    <td style="width: 30%" valign="bottom">
         <center>
            <table>
                <tr>
                    <td style="font-weight: bold; font-size: 14pt">
               FORMULIR TRANSFER PASIEN
                    </td>
                </tr>
            </table>
        </center>
    </td>
    <td style="width: 30%;">
        <table class="borderclass" style="float:right; width: 100%">
            <tr>
                <td style="padding: 2px" width="150px">Nama Pasien</td>
                <td style="padding: 2px" width="10px">:</td>
                <td style="padding: 2px">
                    <?php echo $modPasien->nama_pasien; ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 2px" width="150px">Tanggal Lahir</td>
                <td style="padding: 2px" width="10px">:</td>
                <td style="padding: 2px">
                    <?php echo MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir); ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 2px" width="150px">Jenis Kelamin</td>
                <td style="padding: 2px" width="10px">:</td>
                <td style="padding: 2px">
                    <?php echo $modPasien->jeniskelamin; ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 2px" width="150px">No. RM</td>
                <td style="padding: 2px" width="10px">:</td>
                <td style="padding: 2px">
                    <?php echo $modPasien->no_rekam_medik; ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 2px" width="150px">Dokter DPJP</td>
                <td style="padding: 2px" width="10px">:</td>
                <td style="padding: 2px">
                    <?php 
                        $modAdmisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
                        $nama = "";
                        
                        if(isset($modAdmisi)){
                            $nama = (isset($modAdmisi->dokpenerima)?$modAdmisi->dokpenerima->namaLengkap:"");
                        }
                    echo $nama; ?>
                </td>
            </tr>
        </table>
    </td>
    </tr>
</table>
