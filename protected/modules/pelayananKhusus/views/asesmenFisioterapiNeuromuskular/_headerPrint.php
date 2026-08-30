<table width="100%">
    <tr>
    <td style="width: 25%" class="borderclass" valign="top">
      <div><img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " style="height: 100px; width: 100%;"/></div>

    </td>
    <td style="width: 40%"  class="borderclass" valign="middle">
        <center>
          <div style="font-weight: bold; font-size: 16pt">
            ASESMEN FISIOTERAPI NEUROMUSKULAR
          </div>
        </center>
    </td>
    <td style="width: 35%;" class="borderclass"  valign="top">
        <table class="" style="float:right; width: 100%">
          <tr>
              <td style="padding: 3px; font-size: 11pt">No. RM</td>
              <td style="padding: 3px; font-size: 11pt">:</td>
              <td style="padding: 3px; font-size: 11pt">
                  <?php echo $modPasien->no_rekam_medik; ?>
              </td>
          </tr>
            <tr>
                <td style="padding: 3px; font-size: 11pt" width="120px">Nama</td>
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
        </table>
    </td>
    </tr>
</table>
