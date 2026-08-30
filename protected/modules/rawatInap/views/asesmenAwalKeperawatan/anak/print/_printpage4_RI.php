<table width="100%">
  <tr>
    <td class="textbold padding5 borderclass">
      Psikososial Spiritual
    </td>
  </tr>
  <tr>
    <td class="padding5 borderclass">
      <table width="100%">
        <tr>
          <td width="50%" valign='top'>
            <table width="100%" class="tablefont">
                <tr>
                    <td width="150px">Taat Beribadah</td>
                    <td width="10px">:</td>
                    <td>
                      <span style="padding-left: 5px" class="<?php echo (($model->istaatberibadah ==false)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
                      <span style="padding-left: 5px" class="<?php echo (($model->istaatberibadah ==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya
                    </td>
                </tr>
                <tr>
                    <td>Orang Terdekat</td>
                    <td>:</td>
                    <td>
                      <?php echo $model->orangterdekat; ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top">Perasaan saat ini</td>
                    <td valign="top">:</td>
                    <td>
                      <span class="<?php echo ((!empty($model->perasaansaatini) && ($model->perasaansaatini =='Cemas'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Cemas
                      <span style="padding-left: 5px" class="<?php echo ((!empty($model->perasaansaatini) && ($model->perasaansaatini =='Tenang'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tenang
                    </td>
                </tr>
            </table>
          </td>
          <td width="50%" valign='top'>
            <table width="100%" class="tablefont">
                <tr>
                    <td width="150px" valign="top">Gangguan Orientasi terhadap</td>
                    <td width="5px" valign="top">:</td>
                    <td>
                      <?php echo $model->gangguanorientasi_terhadap; ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top">Keluhan Lain</td>
                    <td valign="top">:</td>
                    <td>
                      <?php echo $model->psikososialspriritual_keluhanlain; ?>
                    </td>
                </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td class="padding5 borderclass">
      Verifikasi Pasien : Tgl <span style="padding-left: 100px"></span> Jam
    </td>
  </tr>
  <tr>
    <td colspan="2" class="padding5 borderclass">
      <table width="100%" class="tablefont">
        <tr>
            <td colspan="3">Dengan ini saya/keluarga menyatakan akan mengikuti aturan perawatan sesuai dengan rencana keperawatan yang berlaku,</td>
        </tr>
        <tr>
          <td width="35%" valign="top">
            <center>
              Tanda Tangan Pasien/Keluarga
              <br/><br/><br/><br/><br/>
              <?php echo $model->namapasien_verifikator; ?>
            </center>
          </td>
          <td width="30%" valign="top">
            <center>
              Tanda Tangan Perawat/Bidan
              <br/><br/><br/><br/><br/>
              <?php echo $model->paramedis_nama; ?>
            </center>
          </td>
          <td width="35%" valign="top">
            <center>
              Tanda Tangan Kepala Ruangan
              <br/><br/><br/><br/><br/>
              <?php
              $pegawaiRuangan = PegawairuanganV::model()->findByAttributes(array('jabatan_id'=>39)); //Jabatan_id = Kepala Ruangan (39)
              echo (isset($pegawaiRuangan)?$pegawaiRuangan->namaLengkap:""); ?>
            </center>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
