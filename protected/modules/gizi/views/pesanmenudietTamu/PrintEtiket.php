<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<style>       
    table.a  tr td 
    {
      vertical-align: top;
    }
    
    table.a  tr td label
    {
      font-size:7pt;
    }
    
    table.a  tr td 
    {
      font-size:7pt;
    }
    
    table  tr td label
    {
      font-size:5pt;
    }
    
    table  tr td 
    {
      font-size:7pt;
    }
    
   @media (min-width:0px) and (max-width: 1000px) {
    table
    {
        width:100%;
        padding:10px;
    }
    
}
</style>
<table width="50%">
        <tbody><tr>
            <td width="80" valign="MIDDLE" align="CENTER" rowspan="3">
                 <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " style="max-width: 80px; width:80px;"/>
            </td>
            <td valign="MIDDLE" align="CENTER" colspan=" 9">
                <b><span size="5pt" color="black" face="Liberation Serif"><b><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></b></span></b>
            </td>
        </tr>
         <tr>
            <td valign="MIDDLE" align="CENTER" colspan=" 9">
                <span color="black" face="Liberation Serif"><?php echo $modProfilRs->alamatlokasi_rumahsakit; ?></span>
            </td>
        </tr>
         <tr>
            <td valign="MIDDLE" align="CENTER" colspan=" 9">
                <span color="black" face="Liberation Serif">Telp. <?php echo $modProfilRs->no_telp_profilrs; ?> Fax.  / <?php echo $modProfilRs->no_faksimili." - ".$modProfilRs->kabupaten->kabupaten_nama; ?></span>
            </td>
        </tr>
         <tr>
            <td height="2" style="border-bottom: 3px solid #000000" colspan=" 10"></td>
        </tr>
                     <tr>
                <td valign="MIDDLE" align="CENTER" colspan=" 10"><span color="black"><h3></h3></span></td>
            </tr>
                         <tr>
            <td valign="MIDDLE" align="CENTER" colspan=" 10"></td>
        </tr>  
</tbody>
</table>
<?php
$modRuangan = RuanganM::model()->findByPk($model->ruangan_id);
$modJenis = JenisdietM::model()->findByPk($model->jenisdiet_id);
$modDetail = PesanmenudetailT::model()->findByAttributes(array('pesanmenudiet_id'=>$model->pesanmenudiet_id));
$modJenisWaktu = JenisWaktuM::model()->findByPk($modDetail->jeniswaktu_id);
$modPasien = PasienM::model()->findByPk($modDetail->pasien_id);
$modPasienAdmisi = PasienadmisiT::model()->findByAttributes(array('pasien_id'=>$modDetail->pasien_id));
$modKamarRuangan = KamarruanganM::model()->findByPk($modPasienAdmisi->kamarruangan_id);

?>
<table width="100%" class="a">
    <tr>
        <td width='32%'>
            <label class='control-label'>Ruangan</label>
        </td>
        <td>:</td>
        <td width='60%'> <?php echo !empty($modRuangan->ruangan_nama)?$modRuangan->ruangan_nama:'-'; ?> </td>
    </tr>
     <tr>
        <td width='32%'>
            <label class='control-label'>No. Kamar</label>
        </td>
        <td>:</td>
        <td width='60%'> <?php echo !empty($modKamarRuangan->kamarruangan_nokamar)?$modKamarRuangan->kamarruangan_nokamar:'-'; ?> </td>
    </tr>
     <tr>
        <td width='32%'>
            <label class='control-label'>No. RM</label>
        </td>
        <td>:</td>
        <td width='60%'> <?php echo !empty($modPasien->no_rekam_medik)?$modPasien->no_rekam_medik:'-'; ?> </td>
    </tr>
     <tr>
        <td width='32%'>
            <label class='control-label'>Nama Pasien</label>
        </td>
        <td>:</td>
        <td width='60%'> <?php echo !empty($modPasien->nama_pasien)?$modPasien->nama_pasien:'-'; ?> </td>
    </tr>
     <tr>
        <td width='32%'>
            <label class='control-label'>Tgl lahir</label>
        </td>
        <td>:</td>
        <td width='60%'> <?php echo !empty($modPasien->tanggal_lahir)? MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir):'-'; ?> </td>
    </tr>
     <tr>
        <td width='32%'>
            <label class='control-label'>Jenis Diet</label>
        </td>
        <td>:</td>
        <td width='60%'> <?php echo !empty($modJenis->jenisdiet_nama)?$modJenis->jenisdiet_nama:'-'; ?> </td>
    </tr>
     <tr>
        <td width='32%'>
            <label class='control-label'>Jam Makan</label>
        </td>
        <td>:</td>
        <td width='60%'> <?php echo !empty($modJenisWaktu->jeniswaktu_nama)?$modJenisWaktu->jeniswaktu_nama:'-'; ?> </td>
    </tr>
    </table>
