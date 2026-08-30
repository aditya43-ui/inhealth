<?php
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();

$path = Params::urlProfilRSPDFPath().$data->logo_rumahsakit;
// var_dump($path);die();
$path2 = Params::urlProfilRSPDFPath().$data->logo_rumahsakit_2;
// var_dump($path.' - '.$path2);die();
$res = "";
$ext = "png";

if (file_exists($path)) {
    //$content = file_get_contents($path);
    //$ext_data = pathinfo($path);
    
    // if (!empty($ext_data) && is_array($ext_data) && !empty($ext_data)) {
    //     $ext = $ext_data['extension'];
    // }
    
    $res = $path;
}

$res2 = "";
$ext = "png";

if (file_exists($path2)) {
    // $content = file_get_contents($path2);
    // $ext_data = pathinfo($path2);
    
    // if (!empty($ext_data) && is_array($ext_data) && !empty($ext_data)) {
    //     $ext = $ext_data['extension'];
    // }
    
    $res2 = $path2;
}

?>
<table width="<?php echo ((isset($width)) ? $width : "100%") ?>" class="headers table-header">
    
    <!--<TD width="15%" height="50%">-->
    <TR>
        <TD WIDTH="15%" ALIGN="CENTER" VALIGN="MIDDLE" >
            <div align="center" >
            <img src="<?php echo $path ?> " class='image_report' style="float:left; max-width: 100px; width:100px;" class='image_report'> 
            </div>
        </TD>
        <TD align="center" style="text-align:center;">
            <div align="center" class="nama_profil" style="color: black !important; ">
                <?php echo $konfig->alamatheadersurat; ?>
            </div>
        </TD>
        <TD WIDTH="15%" ALIGN="CENTER" VALIGN="MIDDLE" >
            <div align="center" >
            <img src="<?php echo $path2 ?> " class='image_report' style="float:left; max-width: 100px; width:100px;" class='image_report'> 
            </div>
        </TD>
    </TR>
    <tr>
        <td colspan="3" style="border-top: 1px solid black;"></td>
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

