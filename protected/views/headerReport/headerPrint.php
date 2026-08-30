<?php 
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();
?>
<table width="100%">
    <tr>
        <td align="center" colspan="<?php echo empty($colspan) ? 7 : $colspan ?>" nowrap>            
            <div>
                <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit_2 ?> " class='image_report' style="height: 80px;"/>
            </div>
            <div>
                <?php echo $konfig->alamatheadersurat; ?>
            </div>          
        </td>
    </tr>
    <tr>
        <td style="border-bottom: 2px solid #000000" colspan="<?php echo empty($colspan) ? 7 : $colspan ?>" nowrap>&nbsp;</td>
    </tr>
</table>