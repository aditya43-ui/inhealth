<?php
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();
?>
<table width="<?php echo ((isset($width)) ? $width : "100%") ?>" class="headers">

    <!--<td width="15%" height="50%">-->
    <tr>
        <td ALIGN=CENTER VALIGN=MIDDLE class="logo_profil">
            <div style="text-align: center;">
                <img src="<?php echo Params::urlProfilRSDirectory() . $data->logo_rumahsakit_2 ?> " style="height:1.3cm;width:6.5cm;" class='image_report'/>
            </div>
        </td>
    </tr>
     <tr>
        <td ALIGN=CENTER VALIGN=MIDDLE class="">
            <div style="text-align: center;">
                <h3><?php echo ((isset($judulLaporan)) ? $judulLaporan : null); ?></h3>
            </div>
        </td>
    </tr>

</table>