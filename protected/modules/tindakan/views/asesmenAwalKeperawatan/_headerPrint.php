<table width="100%">
    <tr>
    <td style="width: 25%" class="borderclass" valign="top">
      <table width="100%" style="float:right; margin-top: 0 !important;">
          <tr>
              <td width="40%" rowspan="4">
                <div><img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " style="height: 100px; width: 120px"/></div>
              </td>
              <td style="font-size: 11pt" class="textright">
                <?php echo (!empty($modProfilRs->nama_rumahsakit)? substr($modProfilRs->nama_rumahsakit,0,11) :""); ?>
              </td>
          </tr>
          <tr>
              <td class="textbold textright" style="font-size: 24pt">
                <?php echo (!empty($modProfilRs->nama_rumahsakit)? substr($modProfilRs->nama_rumahsakit,11,8) :""); ?>
              </td>
          </tr>
          <tr>
              <td style="font-size: 11pt" class="textright">
                  <?php echo (!empty($modProfilRs->nama_rumahsakit)? substr($modProfilRs->nama_rumahsakit,19) :""); ?>
              </td>
          </tr>
          <tr>
              <td style="font-size: 9pt; font-style: italic;" class="textright">
                  Come with Integrity & Safety
              </td>
          </tr>
      </table>

    </td>
    <td style="width: 40%"  class="borderclass" valign="middle">
        <center>
          <div style="font-weight: bold; font-size: 16pt">
            <?php echo $header_print; ?>
          </div>
          <div style="font-weight: bold; font-size: 14pt">
            <?php echo $header_print_title; ?>
          </div>
        </center>
    </td>
    <td style="width: 35%;" class="borderclass"  valign="top">
        <table class="" style="float:right; width: 100%">
            <tr>
                <td style="padding: 3px; font-size: 11pt" width="120px">Nama Pasien</td>
                <td style="padding: 3px; font-size: 11pt" width="5px">:</td>
                <td style="padding: 3px; font-size: 11pt">
                    <?php echo $modPasien->nama_pasien; ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 5px; font-size: 11pt">Tangal Lahir</td>
                <td style="padding: 5px; font-size: 11pt">:</td>
                <td style="padding: 5px; font-size: 11pt">
                    <?php echo MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir); ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 3px; font-size: 11pt">Jenis Kelamin</td>
                <td style="padding: 3px; font-size: 11pt">:</td>
                <td style="padding: 3px; font-size: 11pt">
                    <?php echo $modPasien->jeniskelamin; ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 3px; font-size: 11pt">No. RM</td>
                <td style="padding: 3px; font-size: 11pt">:</td>
                <td style="padding: 3px; font-size: 11pt">
                    <?php echo $modPasien->no_rekam_medik; ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 3px; font-size: 11pt">Dokter DPJP</td>
                <td style="padding: 3px; font-size: 11pt">:</td>
                <td style="padding: 3px; font-size: 11pt">
                    <?php echo (isset($modPendaftaran->dokter)?$modPendaftaran->dokter->namaLengkap:""); ?>
                </td>
            </tr>
        </table>
    </td>
    </tr>
</table>
