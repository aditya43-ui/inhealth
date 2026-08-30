<?php 
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
$konfig = KonfigsystemK::model()->find(); 

?>
<table width="<?php echo ((isset($width)) ? $width : "100%")?>" class="headers paddingtext">       
	<TR>
		<TD ROWSPAN=2 ALIGN=CENTER VALIGN=MIDDLE class="logo_profil">
			 <img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit ?> " style="float:left; max-width: 120px; width:120px;" class='image_report'/>
		</TD>
		
	</TR>
	<TR>
		
        <TD align="center" >
            <div align="center" class="nama_profil">
                <!-- <B>
                    <FONT FACE="Liberation Serif" SIZE=2 color="black">
                        <?php //echo $data->nama_rumahsakit ?>
                    </FONT>
                </B> -->
		</div>
            <div align="center" class="jalan_profil">
                <FONT FACE="Liberation Serif" color="black">
                    <?php echo $konfig->alamatheadersurat ?>
                </FONT>                
            </div>
            <?php /*
            <div align="center" class="kontak_profil">
                <FONT FACE="Liberation Serif" color="black">Telp./Fax. <?php echo $data->no_telp_profilrs ?> / <?php echo $data->no_faksimili ?></FONT>
            </div>
             * 
             */ ?>
        </TD>
    </TR>
    <TR>
        <TD colspan="<?php echo isset($colspan)?$colspan:2 ?>" HEIGHT=2 style="border-bottom: 1px solid #000000">&nbsp;</TD>
    </TR>
    <TR>
        <TD STYLE="text-align:center;" colspan="<?php echo isset($colspan)?$colspan:2 ?>" class="judul" align="center">
            <font color="black"><h4><?php echo ((isset($judulLaporan)) ? $judulLaporan : null); ?></h4></font>
        </TD>
    </TR>   	
</table>
