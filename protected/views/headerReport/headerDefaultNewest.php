<?php //if (empty($is_pdf) || $is_pdf != 1): ?>
<!-- <style>
    
    .nama_profil h4 {
        color: black !important;
    }
    
    .nama_profil blockquote {
        display: none;
    }
    
</style> -->
<?php //endif; ?>


<?php
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();
?>
<table width="<?php echo ((isset($width)) ? $width : "100%") ?>" class="headers table-header">
    
    <!--<TD width="15%" height="50%">-->
    <TR>
        <TD WIDTH="20%" ALIGN="LEFT" VALIGN="MIDDLE" class="logo_profil">
            <div align="center" >
            <img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit ?> "  style="float:left; max-width: 100px; width:100px;" class='image_report'> 
            </div>
        </TD>
        <TD WIDTH="60%" align="center" style="text-align:center;">
            <div align="center" class="nama_profil" style="color: black !important; ">
                <p style="text-align:center;"><?php echo $konfig->alamatheadersurat; ?></p>
            </div>
        </TD>
        <TD WIDTH="20%" ALIGN="RIGHT" VALIGN="MIDDLE" class="logo_profil" >
            <img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit_2 ?> "  style="float:left; max-width: 100px; width:100px;" class='image_report'>
        </TD>
     
    </TR>
    <tr>
        <td colspan="3" ></td>
    </tr>
     <TR>
        <TD  ALIGN=CENTER VALIGN=MIDDLE class="" colspan="3">
            <div align="center" >
                <h3><?php echo ((isset($judulLaporan)) ? $judulLaporan : null); ?></h3>
            </div>
        </TD>
    </TR>
    <TR>
       <TD  ALIGN=CENTER VALIGN=MIDDLE class="" colspan="3">
            <div align="center" >
              <font color="black"><?php echo (isset($periode) ? $periode : '') ?></font>
            </div>
        </TD>
    </TR>

</table>

