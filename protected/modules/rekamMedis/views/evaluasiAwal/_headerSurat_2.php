<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>

<table width="100%">
    <tr>
    <td style="width: 20%" valign="top">
        <table style="border: 2px solid black !important;">
            <tr>
                <td align="center" class="bordertopclass borderbottomclass borderleftclass">
                    <div><img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " style="height: 100px; width: 200px"/></div>
                </td>
            </tr>
        </table>
    </td>
    <td style="width: 35%" valign="top" >
        <center>
            <table>
                <tr>
                  <td  class="">
                    <center>
                      <font style="font-size:12px; font-weight: bold"><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></font><br><br>
                       <font style="font-size:12px;"><?php echo ucwords($modProfilRs->alamatlokasi_rumahsakit). ' '. ucwords(strtolower($modProfilRs->kecamatan->kecamatan_nama)) . ' '.ucwords(strtolower($modProfilRs->kabupaten->kabupaten_nama)); ?></font><br>
                      <font style="font-size:12px;">Phone. <?php echo $modProfilRs->no_telp_profilrs;?></font> <br>
                  <font style="font-size:12px;">FAX : <?php echo $modProfilRs->no_faksimili; ?></font>
                  <center>
                  </td>
                </tr>
            </table>
        </center>
    </td>
    <td style="width: 45%;" valign="top">
        <table class="borderclass" style="float:right; width: 100%; border: 2px solid black; height: 100px">
            <tr>
                <td style="padding: 2px" width="100px">Nama Pasien</td>
                <td style="padding: 2px" width="10px">:</td>
                <td style="padding: 2px">
                    <?php echo $modPasien->nama_pasien; ?>
                </td>

                <td style="padding: 2px" width="100px">No. RM</td>
                <td style="padding: 2px" width="10px">:</td>
                <td style="padding: 2px">
                    <?php echo $modPasien->no_rekam_medik; ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 2px" width="100px">Umur</td>
                <td style="padding: 2px" width="10px">:</td>
                <td style="padding: 2px">
                    <?php echo $modPendaftaran->umur; ?>
                </td>

                <td style="padding: 2px" width="100px">Dokter DPJP</td>
                <td style="padding: 2px" width="10px">:</td>
                <td style="padding: 2px">
                    <?php
                    $pegawaiNamaDpjp = "";
                    $pegawaiId = $modPendaftaran->pegawai_id;

                    if(!empty($pegawaiId)){
                      $modPeg = PegawaiM::model()->findByPk($pegawaiId);
                      $pegawaiNamaDpjp = (isset($modPeg)? $modPeg->namaLengkap:"");
                    }
                        echo $pegawaiNamaDpjp; ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 2px" width="100px">Jenis Kelamin</td>
                <td style="padding: 2px" width="10px">:</td>
                <td style="padding: 2px">
                    <?php echo $modPasien->jeniskelamin; ?>
                </td>
            </tr>
        </table>
    </td>
    </tr>
</table>
