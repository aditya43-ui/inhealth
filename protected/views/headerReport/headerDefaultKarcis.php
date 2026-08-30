<?php 
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
$konfig = KonfigsystemK::model()->find();
?>
<table width="<?php echo ((isset($width)) ? $width : "100%")?>" class="headers">    
<tr>
    <td colspan="<?php echo isset($colspan)?$colspan:2 ?>"></td>
</tr>   
	<!-- <TR>
            <TD style="text-align: center;" align="center" colspan="<?php echo isset($colspan)?$colspan:2 ?>">
			 <img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit ?> " style="text-align: center; max-width: 170px; width:170px;" class='image_report'/>
		</TD>
		
	</TR> -->
	<TR>
		
        <TD align="center" colspan="<?php echo isset($colspan)?$colspan:2 ?>">
            <div align="center" class="nama_profil">
                <!-- <B>
                    <FONT FACE="Liberation Serif" SIZE=4 color="black">
                        <?php //echo $data->nama_rumahsakit ?>
                    </FONT>
                </B> -->
                <?php echo $konfig->alamatheadersurat ?>
		</div>
            <!-- <div align="center" class="jalan_profil">
                <FONT FACE="Liberation Serif" color="black">
                    <?php //echo $konfig->alamatheadersurat ?>
                </FONT>                
            </div> -->
            <?php /*
            <div align="center" class="kontak_profil">
                <FONT FACE="Liberation Serif" color="black">Telp./Fax. <?php echo $data->no_telp_profilrs ?> / <?php echo $data->no_faksimili ?> - <?php echo $data->website; ?></FONT>
            </div>
             * 
             */ ?>
        </TD>
    </TR>
    <TR>
        <TD colspan="2" HEIGHT=2 style="border-bottom: 1px solid #000000">&nbsp;</TD>
    </TR>
    <!-- <TR>
        <TD STYLE="text-align:center;" colspan="<?php echo isset($colspan)?$colspan:2 ?>" class="judul" align="center">
            <font color="black"><h3><?php echo ((isset($judulLaporan)) ? $judulLaporan : null); ?></h3></font>
        </TD>
    </TR>    -->
	<tr>
		<td colspan="<?php echo isset($colspan)?$colspan:2 ?>">&nbsp;</td>
	</tr>
</table>
