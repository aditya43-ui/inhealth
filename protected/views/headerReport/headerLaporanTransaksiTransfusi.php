<?php $data=ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
<table width="100%">
        <TR>
            
            <TD 
                ALIGN=CENTER VALIGN=MIDDLE colspan=" <?php echo (!empty($colspan)) ? ($colspan) : "3"; ?>" style="padding-top: 10px;" nowrap>
                <?php 
                    $caraPrint = isset($_GET['caraPrint'])?$_GET['caraPrint']:null; 
                    
                    if ($caraPrint == 'PDF'){
                ?>
                <B><FONT FACE="arial" SIZE=<?php echo isset($judulFont)?$judulFont:5; ?> color="black">PEMERINTAH PROPINSI JAWA TIMUR RSUD Dr. SOETOMO</FONT></B><BR>
                <B><FONT FACE="arial" SIZE=<?php echo isset($judulFont)?$judulFont:5; ?> color="black">INSTALASI TRANSFUSI DARAH</FONT></B><br>
                <B><FONT FACE="arial" SIZE=<?php echo isset($judulFont)?$judulFont:5; ?> color="black">Sekretariat</FONT></B><br>
                <B><FONT FACE="arial" SIZE=<?php echo isset($judulFont)?$judulFont:3; ?> color="black"><?php echo $data->alamatlokasi_rumahsakit ?> Telp. <?php echo $data->no_telp_profilrs ?> Fax. <?php echo $data->no_faksimili ?></FONT></B><br>
                <B><FONT FACE="arial" SIZE=<?php echo isset($judulFont)?$judulFont:3; ?> color="black">Email : transfusi-rdsd@yahoo.co.id</FONT></B>
            <?php }else{ ?>
                <B><FONT FACE="arial" SIZE=<?php echo isset($judulFont)?$judulFont:3; ?> color="black">PEMERINTAH PROPINSI JAWA TIMUR RSUD Dr. SOETOMO</FONT></B><BR>
                <B><FONT FACE="arial" SIZE=<?php echo isset($judulFont)?$judulFont:3; ?> color="black">INSTALASI TRANSFUSI DARAH</FONT></B><br>
                <B><FONT FACE="arial" SIZE=<?php echo isset($judulFont)?$judulFont:3; ?> color="black">Sekretariat</FONT></B><br>
                <FONT FACE="arial" SIZE=<?php echo isset($judulFont)?$judulFont:3; ?> color="black"><?php echo $data->alamatlokasi_rumahsakit ?> Telp. <?php echo $data->no_telp_profilrs ?> Fax. <?php echo $data->no_faksimili ?></FONT><br>
                <FONT FACE="arial" SIZE=<?php echo isset($judulFont)?$judulFont:3; ?> color="black">Email : transfusi-rdsd@yahoo.co.id</FONT>
                <?php } ?>
            </TD>
        </TR>
         <TR>
            <TD ALIGN=CENTER VALIGN=MIDDLE colspan=" <?php echo (!empty($colspan)) ? ($colspan) : "5"; ?>" nowrap>
                <!--<FONT FACE="arial" color="black"><?php // echo $data->alamatlokasi_rumahsakit ?></FONT>-->
            </TD>
        </TR>
         <TR>
            <TD ALIGN=CENTER VALIGN=MIDDLE colspan=" <?php echo (!empty($colspan)) ? ($colspan-1) : "5"; ?>" nowrap>
                
            </TD>
        </TR>
         <TR>
            <TD colspan=" <?php echo ((!empty($colspan)) ? ($colspan) : 6) + 3; ?>"></TD>
        </TR>
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
