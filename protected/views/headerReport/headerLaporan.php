<?php 
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
$konfig = KonfigsystemK::model()->find(); 
?>
<table width="100%">
    <tr>
        <td width="150">
            <img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit ?> " style="float:left; max-width: 170px; width:170px;" width="170" class='image_report'/>
        </td>
        <td align="center">
            <div>
                <FONT FACE="Liberation Serif" color="black"><?php echo $konfig->alamatheadersurat; ?></FONT>
            </div>
        </td>
        <td width="150">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" HEIGHT=2 style="border-bottom: 3px solid #000000">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" ALIGN=CENTER VALIGN=MIDDLE>
            <font color="black"><h5><?php echo (isset($judulLaporan) ? $judulLaporan : '') ?></h5></font>
        </td>
    </tr>
    <tr>
        <td colspan="3" ALIGN=CENTER VALIGN=MIDDLE>
            <font color="black"><?php echo (isset($periode) ? $periode : '') ?></font>
        </td>
    </tr>
    <tr>
        <td colspan="3" ALIGN=CENTER VALIGN=MIDDLE>&nbsp;</td>
    </tr>        
</table>