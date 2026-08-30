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
		
        <TD align="left" style="text-align:left;">
            <div align="left" class="jalan_profil">
                <FONT FACE="Liberation Serif" color="black" size="5">
                    RUMAH SAKIT
                    <?php //echo $data->nama_rumahsakit; //echo $konfig->alamatheadersurat; ?>
                </FONT><br/>
                <FONT FACE="Liberation Serif" color="black" size="5">
                    SARI ASIH
                </FONT><br/>
                <FONT FACE="Liberation Serif" color="black" size="5">
                    CIPUTAT
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
