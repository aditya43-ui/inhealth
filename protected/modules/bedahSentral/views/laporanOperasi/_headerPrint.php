<table width="100%">
  <tr>
    <td style="width: 70%" class="" valign="top">
      <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " style="max-width: 35%"/>
    </td>
    <td style="text-align: right;" valign="bottom">
    <div class="textbold headertext">RM. 028</div>
    </td>
  </tr>
</table>

<table width="100%">
  <tr>
    <td style="width: 60%"  class="" valign="middle">
        <center>
          <div style="font-weight: bold; font-size: 11pt">
            LAPORAN OPERASI
          </div>
        </center>
    </td>
    <td style="width: 40%;" class="borderclass"  valign="top">
        <table class="" style="float:right; width: 100%">
          <tr>
              <td style="padding: 3px; font-size: 10pt" width="120px">No. RM</td>
              <td style="padding: 3px; font-size: 10pt" width="5px">:</td>
              <td style="padding: 3px; font-size: 10pt">
                  <?php echo $modPasien->no_rekam_medik; ?>
              </td>
          </tr>
            <tr>
                <td style="padding: 3px; font-size: 10pt">Nama</td>
                <td style="padding: 3px; font-size: 10pt">:</td>
                <td style="padding: 3px; font-size: 10pt">
                    <?php echo $modPasien->nama_pasien; ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 5px; font-size: 10pt">Tgl. Lahir</td>
                <td style="padding: 5px; font-size: 10pt">:</td>
                <td style="padding: 5px; font-size: 10pt">
                  <span style="text-align: left;"> 
                    <?php echo MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir); ?>  
                  </span>    
                  <span style="text-align: right; padding-left: 20px"> 
                    <span class="<?php  echo ((!empty($modPasien->jeniskelamin) && $modPasien->jeniskelamin == Params::JENIS_KELAMIN_LAKI_LAKI)? "textcoret": "") ?>">L</span>/<span class="<?php echo ((!empty($modPasien->jeniskelamin) && $modPasien->jeniskelamin == Params::JENIS_KELAMIN_PEREMPUAN)? "textcoret": "") ?>">P</span>
                  </span>    
                </td>
            </tr>
            
        </table>
    </td>
  </tr>
</table>
