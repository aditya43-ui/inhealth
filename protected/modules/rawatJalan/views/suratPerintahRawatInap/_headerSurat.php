<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>

<table width="100%">
        <TR>
            <TD ROWSPAN=3 WIDTH=80 ALIGN=CENTER VALIGN=MIDDLE>
                 <?php if(!empty($modProfilRs->logo_rumahsakit) && file_exists(Params::pathProfilRSDirectory().$modProfilRs->logo_rumahsakit)){ ?>
                    <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit; ?> " style="float:left; max-width: 120mm; width:30mm; height: 20mm" class='image_report'/>
                <?php } ?>
                 
            </TD>
        </TR>
         <TR>
            <TD ALIGN=CENTER VALIGN=MIDDLE>
                <B><FONT FACE="Liberation Serif" SIZE=4><?php echo $modProfilRs->nama_rumahsakit; ?></FONT></B>
            </TD>
        </TR>
         <TR>
            <TD ALIGN=CENTER VALIGN=MIDDLE>
                <FONT FACE="Liberation Serif"><?php echo ucwords($modProfilRs->alamatlokasi_rumahsakit). ' '. ucwords(strtolower($modProfilRs->kecamatan->kecamatan_nama)) . ' '.ucwords(strtolower($modProfilRs->kabupaten->kabupaten_nama)); ?>
                <br /> 
                Phone : <?php echo $modProfilRs->no_telp_profilrs; ?> FAX : <?php echo $modProfilRs->no_faksimili; ?>
                </FONT>
            </TD>
        </TR>
         <TR>
            <TD COLSPAN=2 HEIGHT=2 style="border-bottom: 3px solid #000000"></TD>
        </TR>
</table>

