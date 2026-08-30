<?php
/*
 * id pada attribute iamge digunakan untuk pengaturan header di halaman lain
 */
?>
<?php 
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
$konfig = KonfigsystemK::model()->find();
?>

<table width="100%" border="0px">
    <tr>
        <td width="25%" align="center" >
            <img src="<?php echo Params::pathImageErrorAdmin()."Jawa_Timur.png"?> " id="headerset" style="max-width: 80px; width:80px;"/>
        </td>
        <td align="center">
            <div>
                <?php echo $konfig->alamatheadersurat; ?>
                <!--<b>PEMERINTAH PROPINSI <?php // echo strtoupper($modProfilRs->propinsi->propinsi_nama); ?></b>-->
            </div>
        </td>
        <td width="25%" align="center">
            
            <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " id="headerset2" style="max-width: 80px; width:80px;"/>
        </td>
    </tr>
    
</table>
