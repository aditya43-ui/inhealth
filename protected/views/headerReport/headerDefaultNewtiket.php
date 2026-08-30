
<?php
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();
?>
<table width="<?php echo ((isset($width)) ? $width : "100%") ?>" class="headers">

    <!--<TD width="15%" height="50%">-->
    <TR>
        <TD  ALIGN=CENTER VALIGN=MIDDLE class="logo_profil">
            <div align="center" >
                <img src="<?php echo Params::urlProfilRSDirectory() . $data->logo_rumahsakit_2 ?> " style="height:0.8cm;" class='image_report'/>
            </div>
        </TD>
    </TR>

</table>
