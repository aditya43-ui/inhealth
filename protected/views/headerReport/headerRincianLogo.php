<style>  
    /*
    body{
        width: 10cm;
        height: 11cm;
    }*/
</style>
<?php 
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();   
?>
<table width="100%">
    <tr>
        <td style="text-align:center;">
            <div>
                <img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit_2 ?> " class='image_report' style="height: 80px;"/>
            </div>
            <div>
                <FONT FACE="Liberation Serif" SIZE=1 color="black"><?php echo $konfig->alamatheadersurat ?></FONT>
            </div>
            <?php /*
            <div>
                <FONT FACE="Liberation Serif" SIZE=1 color="black">Telp./Fax. <?php echo $data->no_telp_profilrs ?> / <?php echo $data->no_faksimili ?></FONT>
            </div>
             * 
             */ ?>
        </td>
    </tr>
    <tr>
        <td colspan="1" HEIGHT=2 style="border-bottom: 3px solid #000000">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="1" style="text-align:center;" VALIGN=MIDDLE>
            <font color="black"><h5><?php echo (isset($judulLaporan) ? $judulLaporan : '') ?></h5></font>
        </td>
    </tr>
    <tr>
        <td colspan="1" ALIGN=CENTER VALIGN=MIDDLE>
            <font color="black"><?php echo (isset($periode) ? $periode : '') ?></font>
        </td>
    </tr>     
</table>