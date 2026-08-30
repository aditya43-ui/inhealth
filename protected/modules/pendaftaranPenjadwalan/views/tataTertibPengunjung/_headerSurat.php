<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<style type="text/css">
    .borderclass {
        border: 1px solid black;
    }
    .bordertopclass {
        border-top: 1px solid black;
    }
    .borderrightclass {
        border-right: 1px solid black;
    }
    .borderleftclass {
        border-left: 1px solid black;
    }
    .borderbottomclass {
        border-bottom: 1px solid black !important;
    }
</style>
<table width="100%">
        <TR>
            <TD ROWSPAN=3 WIDTH=80 ALIGN=CENTER VALIGN=MIDDLE>
                 <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit; ?> " style="float:left; max-width: 120px; width:120px;" class='image_report'/>
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
<br>
<table width="100%">
    <TR>
        <TD ALIGN=CENTER VALIGN=MIDDLE>
            <B><FONT FACE="Liberation Serif" SIZE=4>FORMULIR PENERIMA INFORMASI KONDISI PASIEN</FONT></B>
        </TD>
    </TR>
</table>
