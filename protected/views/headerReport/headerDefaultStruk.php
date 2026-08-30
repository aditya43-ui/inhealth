<?php 
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find(); 
?>
<table width="100%">
          <TR>
            <TD ROWSPAN=4 ALIGN=CENTER VALIGN=MIDDLE>
                 <img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit ?> " style="float:left; max-width: 80px; width:80px;" class='image_report'/>
            </TD>
        </TR>
         <TR>
            <TD ALIGN=CENTER VALIGN=MIDDLE colspan="<?php echo (!empty($colspan)) ? ($colspan-1) : "5"; ?>">
                <B><FONT FACE="Liberation Serif" SIZE=4 color="black"><?php //echo $data->nama_rumahsakit ?></FONT></B>
            </TD>
        </TR>
         <TR>
            <TD ALIGN=CENTER VALIGN=MIDDLE colspan=" <?php echo (!empty($colspan)) ? ($colspan-1) : "5"; ?>">
                <FONT FACE="Liberation Serif" color="black"><?php echo $konfig->alamatheadersurat ?></FONT>
            </TD>
        </TR>
        <?php /*
        <TR>
            <TD ALIGN=CENTER VALIGN=MIDDLE colspan=" <?php echo (!empty($colspan)) ? ($colspan-1) : "5"; ?>">
                <FONT FACE="Liberation Serif" color="black"> Telp./Fax. <?php echo $data->no_telp_profilrs ?> / <?php echo $data->no_faksimili ?></FONT>
            </TD>
        </TR>
         * 
         */ ?>
         <TR>
            <TD colspan=" <?php echo (!empty($colspan)) ? ($colspan) : "6"; ?>" HEIGHT=2 style="border-bottom: 2px solid #000000"></TD>
        </TR>
         <TR>
            <TD colspan=" <?php echo (!empty($colspan)) ? ($colspan) : "6"; ?>" ALIGN=CENTER VALIGN=MIDDLE ><font color="black"><h5><?php echo (isset($judulLaporan) ? $judulLaporan : '') ?></h5></font></TD>
        </TR>
         <TR>
            <TD colspan=" <?php echo (!empty($colspan)) ? ($colspan) : "6"; ?>" ALIGN=CENTER VALIGN=MIDDLE></TD>
        </TR>  
</table>
