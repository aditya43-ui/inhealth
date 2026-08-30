<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
<div class="pull-right">
    FRM/55.1 Rev 01/RSBM
</div>
<div class="clear"></div>
<table width="100%" style="border-collapse: collapse;">
    <tr>
        <td width="300" style="padding: 5px;">
            <table>
                <tr>
                    <td><img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> "
                            style="max-width: 80px; width:80px;" /></td>
                    <td align="left">
                    </td>
                </tr>
            </table>

        </td>
        <td></td>

    </tr>
</table>
<br />