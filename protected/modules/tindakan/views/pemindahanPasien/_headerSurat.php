<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<table width="100%">
    <tr>
    <td style="width: 40%; padding: 10px 20px; text-align: center;" valign="top" class="borderclass">
      <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " style="height: 80px; width: 100%"/>
    </td>
    <td style="width: 25%; text-align: center" class="borderclass padding5">
    <center>
        <b>CATATAN PEMINDAHAAN PASIEN</b>
    </center>
    </td>
    <td style="width: 35%;" class="borderclass padding5">
        <table class=" " style="width: 100%">
          <tr>
              <td style="padding: 2px" width="150px">No. RM</td>
              <td style="padding: 2px" width="10px">:</td>
              <td style="padding: 2px">
                  <?php echo $modPasien->no_rekam_medik; ?>
              </td>
          </tr>
          <tr>
              <td style="padding: 2px" width="150px">Nama</td>
              <td style="padding: 2px" width="10px">:</td>
              <td style="padding: 2px">
                  <?php echo $modPasien->nama_pasien; ?>
              </td>
          </tr>
          <tr>
              <td style="padding: 2px" width="150px">Tgl Lahir</td>
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
        </table>
    </td>
    </tr>
</table>
