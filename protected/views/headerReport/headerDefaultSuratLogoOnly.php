<?php $data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());?>

<table width="100%">
        <TR>
            <TD ALIGN=CENTER VALIGN=MIDDLE width="100%" style="vertical-align: middle;">
                <img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit_2; ?> " class='image_report' style="height: 50px;"/>
            </TD>
        </TR>
        <TR>
            <TD>&nbsp;</TD>
        </TR>
</table>