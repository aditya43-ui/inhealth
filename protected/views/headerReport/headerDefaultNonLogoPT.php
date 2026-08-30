<?php 
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
$konfig = KonfigsystemK::model()->find(); 

?>
<table width="<?php echo ((isset($width)) ? $width : "100%")?>" class="headers">       
	<TR>
		
        <TD align="center" colspan="<?php echo isset($colspan)?$colspan:2 ?>">
            <div align="center" class="nama_profil">
                <B>
                    <FONT FACE="Liberation Serif" SIZE="5" color="black">
                        <?php echo $data->alamatheadersurat ?>
                    </FONT>
                </B>
		</div>
            <!-- <div align="center" class="jalan_profil">
                <FONT FACE="Liberation Serif" size="3" color="black">
                <h4><?php // echo $data->alamatlokasi_rumahsakit.", Kec. ".(isset($data->kecamatan)?$data->kecamatan->kecamatan_nama:"").", Kab. ".(isset($data->kabupaten)?$data->kabupaten->kabupaten_nama:""); ?><br />
                    <?php //echo "Telp : ". $data->no_telp_profilrs.' Email : hrd@pmc.co.id Website : '.$data->website;  ?></h4>
                </FONT>                
            </div> -->
        </TD>
    </TR>
    <TR>
        <TD colspan="<?php echo isset($colspan)?$colspan:2 ?>" HEIGHT=2 style="border-bottom: 1px solid #000000">&nbsp;</TD>
    </TR>
    <TR>
        <TD STYLE="text-align:center;" colspan="<?php echo isset($colspan)?$colspan:2 ?>" class="judul" align="center">
            <font color="black"><h3><?php echo ((isset($judulLaporan)) ? $judulLaporan : null); ?></h3></font>
        </TD>
    </TR>   
	<tr>
		<td colspan="<?php echo isset($colspan)?$colspan:2 ?>">&nbsp;</td>
	</tr>
</table>
