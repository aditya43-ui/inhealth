<?php
$profil = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT);
        $alamat=!empty($profil->alamatlokasi_rumahsakit)?$profil->alamatlokasi_rumahsakit:"";
	$motto=!empty($profil->motto)?$profil->motto:"";
        $telp=!empty($profil->no_telp_profilrs)?$profil->no_telp_profilrs:"";
        $email=!empty($profil->email)?$profil->email:"";
        $website=!empty($profil->website)?$profil->website:"";
        $layoutkiri=$alamat."<br>"."Telp:".$telp." Email:".$email." Website:".$website;

$author = "Authorized by:";
$suplogo = "Hasil sudah divalidasi secara elektronik tidak perlu tanda tangan";
?>
<!-- <table width="100%" class="footer"> -->
    <tr><td width="50%" style="text-align:left" align="left" class="alamatfooter" >
    <?php echo  $layoutkiri ?>
</td>
<td class="mottofooter" style="text-align:right"  width="50%" align="right">
<img src="images/images_footer.png" style="height:35px;"/>
</td></tr>
<!-- </table> -->