<?php 
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();
?>
<table width="100%">
    <tr>
        <td align="center" nowrap>            
            <div>
                <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit_2 ?> " class='image_report' style="height: 80px;"/>
            </div>
            <div>
                <?php echo $konfig->alamatheadersurat; ?>
            </div>
            <?php /*
            <div>
                Telp. <?php echo $modProfilRs->no_telp_profilrs; ?> / Fax. <?php echo $modProfilRs->no_faksimili; ?> - <?php echo $modProfilRs->website; ?>
            </div>
             * 
             */ ?>
        </td>
    </tr>
    <tr>
        <td style="border-bottom: 2px solid #000000">&nbsp;</td>
    </tr>
</table>