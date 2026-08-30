<?php 
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();   
?>
<table width="100%">
    <tr>
        <td width="50">
            <?php
            if(file_exists(Params::urlProfilRSDirectory().$data->logo_rumahsakit)){ ?>
                <img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit ?> " style="float:left; max-width: 80px; width:80px;" class='image_report'/>
            <?php
            }
            ?>
        </td>
        <td align="center">
            <div>
                <B><FONT FACE="Liberation Serif" SIZE=4 color="black"><?php //echo $data->nama_rumahsakit ?></FONT></B>
            </div>
            <div>
                <FONT FACE="Liberation Serif" SIZE=1 color="black"><?php echo $konfig->alamatheadersurat ?></FONT>
            </div>
            <div>
                <!-- <FONT FACE="Liberation Serif" SIZE=1 color="black">Telp./Fax. <?php //echo $data->no_telp_profilrs ?> / <?php echo $data->no_faksimili ?></FONT> -->
            </div>
        </td>
        
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
</table>