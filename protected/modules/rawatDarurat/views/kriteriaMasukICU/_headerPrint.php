<table width="100%">
    <tr>
    <td style="width: 25%" class="borderclass" valign="top">
      <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " style="height: 100px; width: 100%"/>
    </td>
    <td style="width: 40%"  class="borderclass" valign="middle">
        <center>
          <div style="font-weight: bold; font-size: 14pt">
            KRITERIA MASUK ICU
          </div>
        </center>
    </td>
    <td style="width: 35%;" class="borderclass"  valign="top">
        <table class="" style="float:right; width: 100%">
          <tr>
              <td width="120px" style="padding: 3px; font-size: 11pt">No. RM</td>
              <td width="5px" style="padding: 3px; font-size: 11pt">:</td>
              <td style="padding: 3px; font-size: 11pt">
                  <?php echo $modPasien->no_rekam_medik; ?>
              </td>
          </tr>
            <tr>
                <td style="padding: 3px; font-size: 11pt">Nama</td>
                <td style="padding: 3px; font-size: 11pt">:</td>
                <td style="padding: 3px; font-size: 11pt">
                    <?php echo $modPasien->nama_pasien; ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 5px; font-size: 11pt">Tgl Lahir</td>
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
                <td style="padding: 5px; font-size: 11pt">Tanggal</td>
                <td style="padding: 5px; font-size: 11pt">:</td>
                <td style="padding: 5px; font-size: 11pt">
                    <?php echo MyFormatter::formatDateTimeForUser($model->tanggal_pemeriksaan); ?>
                </td>
            </tr>
        </table>
    </td>
  </tr>
</table>
