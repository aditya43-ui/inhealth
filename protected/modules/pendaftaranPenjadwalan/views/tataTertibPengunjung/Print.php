<style>
    body{
        color: black !important;
    }
    h5{
        color: black !important;
    }
    label{
        color: black !important;
    }
    .tab_header {
        width: 100%;
    }
    .pilihan_ijin, .pilihan_privasi {
        font-weight: bold;
        cursor: pointer;
    }

    .borderclass {
        border: 1px solid black;
    }
    .bordertopclass {
        border-top: 1px solid black;
    }
    .borderrightclass {
        border-right: 1px solid black;
    }
    .borderleftclass {
        border-left: 1px solid black;
    }
    .borderbottomclass {
        border-bottom: 1px solid black !important;
    }


</style>


<?php
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
?>

<div class="pull-right" style="font-weight: bold"><?php echo (isset($modMasterTataTertib)?$modMasterTataTertib->tatatertibpengunjung_no_rm :"") ?></div>
<br>
<table width="100%">
    <tr>
    <td style="width: 30%" valign="top">
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
    <td style="width: 35%" valign="bottom" >
        <center>
            <table>
                <tr>
                    <td style="font-weight: bold; font-size: 14pt;">
                        <?php echo $model->tatatertibpengunjung_judul; ?>
                    </td>
                </tr>
            </table>
        </center>
    </td>
    <td style="width: 35%;">
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
                  <?php  $modPeg = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id); ?>
                  <?php echo (isset($modPeg)? $modPeg->namaLengkap:""); ?>

                </td>
            </tr>
        </table>
    </td>
    </tr>
</table>
<br>
<table width="100%">
  <tr>
      <td class="borderclass" style="padding: 10px">
          <?php echo $model->tatatertibpengunjung_isi; ?>
      </td>
  </tr>
</table>

<br/>

<?php    
    if(!empty($urlId) && $urlId == 'pendaftaranRawatInapDariRJRD'){
        ?>
        <table width="100%">
        <tr>
            <td style="text-align: center;" width="50%">
                Menyetujui, </br>
                Pendamping Pasien
                <br/><br/><br/><br/><br/>
                (<?php echo $model->namapihak_menyetujui; ?>)
            </td>
            <td style="text-align: center;" width="50%">
                Petugas
                <br/><br/><br/><br/><br/>
                (<?php echo $model->petugas_menyetujui; ?>)
            </td>
        </tr>
        </table>
        <?php
    }else{
        ?>
        <table width="100%">
            <tr>
                <td style="text-align: center;" width="35%">
                    Pasien
                    <br/><br/><br/><br/><br/>
                    (<?php echo $model->namapasien_menyetujui; ?>)
                </td>
                <td style="text-align: center;" width="30%">
                    Menyetujui, </br>
                    Pendamping Pasien
                    <br/><br/><br/><br/><br/>
                    (<?php echo $model->namapihak_menyetujui; ?>)
                </td>
                <td style="text-align: center;" width="35%">
                    Petugas
                    <br/><br/><br/><br/><br/>
                    (<?php echo $model->petugas_menyetujui; ?>)
                </td>
            </tr>
            </table>
        <?php
    }
?>

