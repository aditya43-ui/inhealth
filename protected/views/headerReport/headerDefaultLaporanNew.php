<?php
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();
?>
<table width="<?php echo ((isset($width)) ? $width : "100%") ?>" class="headers">

    <!--<TD width="15%" height="50%">-->
    <TR>
        <TD  ALIGN=CENTER VALIGN=MIDDLE class="logo_profil">
            <div align="center" >
                <img src="<?php echo Params::urlProfilRSDirectory() . $data->logo_rumahsakit_2 ?> " style="height:1.3cm;width:6.5cm;" class='image_report'/>
            </div>
        </TD>
    </TR>
     <TR>
        <TD  ALIGN=CENTER VALIGN=MIDDLE class="">
            <div align="center" >
                <h3><?php echo ((isset($judulLaporan)) ? $judulLaporan : null); ?></h3>
            </div>
        </TD>
    </TR>
     <?php
            $periode = (isset($periode) ? $periode : null);
            if(isset($periode) || strlen($periode) > 0){
        ?>
            <TR>
                <TD  ALIGN=CENTER VALIGN=MIDDLE><font color="black" style='font-size:11px'><?php echo $periode ?></font></TD>
            </TR>  
        <?php
            }
        ?>       

</table>
