<?php 
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();
?>
<table width="<?php echo ((isset($width)) ? $width : "100%")?>">
    <TR>
        <TD width="15%">
            <img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit ?> " style="float:left; max-width: 80px; width:80px;" class='image_report'/>
        </TD>
        <TD align="center" width="90%">
            <div align="center">
                <!-- <B>
                    <FONT FACE="Liberation Serif" SIZE=4 color="black" style="margin-left: 20px">
                        <?php //echo "<u><i>".Yii::app()->user->getState('nama_rumahsakit')."</i></u>" ?>
                    </FONT>
                </B> -->
                <?php echo $konfig->alamatheadersurat ?>
            </div>
            <!-- <div align="center">
                <FONT FACE="Liberation Serif" color="black">
                    <i><?php //echo $konfig->alamatheadersurat ?></i>
                </FONT>                
            </div> -->
            <?php /*
            <div align="center" style="font-size:14px;">
                <FONT FACE="Liberation Serif" color="black"><i>Telp./Fax. <?php echo $data->no_telp_profilrs ?> / <?php echo $data->no_faksimili ?></i></FONT>
            </div>
             * 
             */ ?>
        </TD>
        <TD width="15%">&nbsp;</TD>
    </TR>
    <TR>
        <TD colspan="3" HEIGHT=2 style="border-bottom: 1px solid #ffffff">&nbsp;</TD>
    </TR>
    <TR>
        <TD ALIGN=CENTER colspan="3">
            <font color="black"><h5><?php echo ((isset($judulLaporan)) ? $judulLaporan : null); ?></h5></font>
        </TD>
    </TR>    
</table>
<!--
<table width="100%" border="1">
        <TR>
            <TD ROWSPAN=4 ALIGN=CENTER VALIGN=MIDDLE>
                 <img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit ?> " style="float:left; max-width: 80px; width:80px;" class='image_report'/>
            </TD>
        </TR>
         <TR>
            <TD ALIGN=CENTER VALIGN=MIDDLE colspan=" <?php echo (!empty($colspan)) ? ($colspan-1) : "5"; ?>">
                <B><FONT FACE="Liberation Serif" SIZE=4 color="black" style="margin-left: 20px"><?php echo $data->nama_rumahsakit ?></FONT></B>
            </TD>
        </TR>
         <TR>
            <TD ALIGN=CENTER VALIGN=MIDDLE colspan=" <?php echo (!empty($colspan)) ? ($colspan-1) : "5"; ?>">
                <FONT FACE="Liberation Serif" color="black"><?php echo $data->alamatlokasi_rumahsakit ?></FONT>
            </TD>
        </TR>
         <TR>
            <TD ALIGN=CENTER VALIGN=MIDDLE colspan=" <?php echo (!empty($colspan)) ? ($colspan-1) : "5"; ?>">
                <FONT FACE="Liberation Serif" color="black">Telp./Fax. <?php echo $data->no_telp_profilrs ?> / <?php echo $data->no_faksimili ?></FONT>
            </TD>
        </TR>
         <TR>
            <TD colspan=" <?php echo (!empty($colspan)) ? ($colspan) : "6"; ?>" HEIGHT=2 style="border-bottom: 1px solid #000000"></TD>
        </TR>
         <TR>
             <TD colspan=" <?php echo (!empty($colspan)) ? ($colspan) : "6"; ?>" ALIGN=CENTER VALIGN=MIDDLE ><font color="black"><h5><?php echo ((isset($judulLaporan)) ? $judulLaporan : null); ?></h5></font></TD>
        </TR>
         <TR>
            <TD colspan=" <?php echo (!empty($colspan)) ? ($colspan) : "6"; ?>" ALIGN=CENTER VALIGN=MIDDLE></TD>
        </TR>  
</table>-->