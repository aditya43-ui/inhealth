<?php 
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
$konfig = KonfigsystemK::model()->find();   

?>
<table width="100%">
    <tr>
        <td width="25%" align="center">
            <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " style="max-width: 150px; width:150px;"/>
        </td>
        <td align="center" colspan="<?php echo isset($colspan)?$colspan:2 ?>" nowrap> 
            <div>
                <?php echo $konfig->alamatheadersurat; ?>
            </div>
        </td>
        <td width="25%" align="center">
            &nbsp;
        </td>
    </tr>
    <tr>
        <td colspan="3" style="border-bottom: 2px solid #000000">&nbsp;</td>
    </tr>
</table>
<div style="font-size: 16px; text-align: center; margin-top: 20px; font-weight: bold;"><?php echo $judulLaporan; ?></div>
<div style="text-align: center; margin-bottom: 20px;"><?php echo $periode; ?></div>