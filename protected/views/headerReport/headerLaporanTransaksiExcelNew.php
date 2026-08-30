<?php 
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();  
?>
<table width="100%" id="headerlaporan">
        <TR>
            <TD ROWSPAN="1" WIDTH="80" ALIGN="CENTER" VALIGN="MIDDLE">
                <?php 
                    $caraPrint = isset($_GET['caraPrint'])?$_GET['caraPrint']:null; 
                    
                    if ($caraPrint == 'PDF'){
                ?>
                <img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit ?> " width ="80" align="center" style="float:left; "class='image_report' />
                    <?php }else{ ?>
                    <img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit ?>" width ="80"  align="center" style="float:left;" class='image_report'/>
                 
                 <?php } ?>
            </TD>
            <TD ALIGN=CENTER VALIGN=MIDDLE colspan=" <?php echo (!empty($colspan)) ? ($colspan-1) : "5"; ?>" nowrap>
                <B><FONT FACE="Liberation Serif" color="black"><?php echo $konfig->alamatheadersurat ?></FONT></B>
            </TD>
            <TD ROWSPAN="1" rowspan="3" WIDTH="80" ALIGN="CENTER" VALIGN="MIDDLE">
                &nbsp;
            </TD>
        </TR>
        <?php /*
         <TR>
            <TD ALIGN=CENTER VALIGN=MIDDLE colspan=" <?php echo (!empty($colspan)) ? ($colspan-1) : "5"; ?>" nowrap>
                <FONT FACE="Liberation Serif" color="black">Telp./Fax. <?php echo $data->no_telp_profilrs ?> / <?php echo $data->no_faksimili ?> - <?php echo $data->website; ?></FONT>
            </TD>
        </TR>
         * 
         */ ?>
         <TR>
            <TD colspan=" <?php echo ((!empty($colspan)) ? ($colspan) : 6) + 3; ?>" HEIGHT=2 style="border-bottom: 3px solid #000000" ></TD>
        </TR>
        <?php
            if(isset($judulLaporan) || strlen($judulLaporan) > 0){
        ?>
            <TR>
                <TD colspan=" <?php echo ((!empty($colspan)) ? ($colspan) : 6) + 3; ?>" ALIGN=CENTER VALIGN=MIDDLE ><font color="black"><h3><?php echo $judulLaporan ?></h3></font></TD>
            </TR>
        <?php
            }
        ?>
        <?php
            $periode = (isset($periode) ? $periode : null);
            if(isset($periode) || strlen($periode) > 0){
        ?>
            <TR>
                <TD colspan=" <?php echo ((!empty($colspan)) ? ($colspan) : 6) + 3; ?>" ALIGN=CENTER VALIGN=MIDDLE><font color="black"><?php echo $periode ?></font></TD>
            </TR>  
        <?php
            }
        ?>
         <TR>
            <TD colspan=" <?php echo ((!empty($colspan)) ? ($colspan) : 6) + 3; ?>" ALIGN=CENTER VALIGN=MIDDLE></TD>
        </TR>  
</table>
