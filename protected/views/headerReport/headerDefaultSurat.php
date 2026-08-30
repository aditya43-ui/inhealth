<?php 
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find(); 

?>

<table width="100%">
        <TR>
            <TD ROWSPAN=1 WIDTH=80 ALIGN=CENTER VALIGN=MIDDLE>
                 <img src="<?php echo 'data:image/png;base64,'.base64_encode(file_get_contents(Params::urlProfilRSDirectory().$data->logo_rumahsakit)); ?> " style="width:80px;" class='image_report'/>
                 
            </TD>
            <TD ALIGN=CENTER VALIGN=MIDDLE width="100%">
                <B><FONT FACE="Liberation Serif" SIZE=4><?php echo $konfig->alamatheadersurat; ?></FONT></B>
            </TD>
            <TD ROWSPAN=1 WIDTH=80 ALIGN=CENTER VALIGN=MIDDLE>
                 <div style="float:left; max-width: 150px; width:150px;"/>
            </TD>
        </TR>
        <?php /*
         <TR>
            <TD ALIGN=CENTER VALIGN=MIDDLE>
                <FONT FACE="Liberation Serif">Telp./Fax. <?php echo $data->no_telp_profilrs; ?> / <?php echo $data->no_faksimili; ?></FONT>
            </TD>
        </TR>
         * 
         */ ?>
         <TR>
            <TD COLSPAN=3 HEIGHT=2 style="border-bottom: 3px solid #000000"></TD>
        </TR>
</table>