<?php 
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find(); 
?>
<table width="100%" class="headers paddingtext">       
	<TR>
		<TD ROWSPAN=2 ALIGN=CENTER VALIGN=MIDDLE class="logo_profil" width="15%">
			 <img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit ?> " style="float:left; max-width: 140px; width:140px;" class='image_report'/>
		</TD>
		
	</TR>
	<TR>
		
        <TD align="center" style="text-align:center;">
            <div align="center" class="jalan_profil">
                <FONT FACE="Liberation Serif" color="black" size="4">
                    <?php echo $konfig->alamatheadersurat; ?>
                </FONT>                
            </div>
        </TD>
    </TR>
    <TR>
        <TD colspan="<?php echo isset($colspan)?$colspan:3 ?>" HEIGHT=2 style="border-bottom: 1px solid #000000">&nbsp;</TD>
    </TR>
    <TR>
        <TD STYLE="text-align:center;" colspan="<?php echo isset($colspan)?$colspan:3 ?>" class="judul" align="center">
            <font color="black"><span style="font-size:13px !important;"><?php echo ((isset($judulLaporan)) ? $judulLaporan : null); ?></span></font>
			<!--<font color="black"><h5 ><?php echo ((isset($judulLaporan)) ? $judulLaporan : null); ?></h5></font>-->
        </TD>
    </TR>   	
	<TR>
		<TD>&nbsp;</TD>
	</TR>
</table>
