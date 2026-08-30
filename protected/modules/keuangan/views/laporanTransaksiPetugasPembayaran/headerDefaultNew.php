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

$path = Params::pathProfilRSDirectory().$data->logo_rumahsakit;
// var_dump($path);die();
$path2 = Params::pathProfilRSDirectory().$data->logo_rumahsakit_2;

$res = "";
$ext = "png";

if (file_exists($path)) {
    $content = file_get_contents($path);
    $ext_data = pathinfo($path);
    
    if (!empty($ext_data) && is_array($ext_data) && !empty($ext_data)) {
        $ext = $ext_data['extension'];
    }
    
    $res = "data:image/".$ext.";base64,". base64_encode($content);
}
// var_dump($res);die();
$res2 = "";
$ext = "png";

if (file_exists($path2)) {
    $content = file_get_contents($path2);
    $ext_data = pathinfo($path2);
    
    if (!empty($ext_data) && is_array($ext_data) && !empty($ext_data)) {
        $ext = $ext_data['extension'];
    }
    
    $res2 = "data:image/".$ext.";base64,". base64_encode($content);
}

?>
<table width="<?php echo ((isset($width)) ? $width : "100%") ?>" class="headers table-header">
    
    <!--<TD width="15%" height="50%">-->
    <TR>
        <TD WIDTH="20%" ALIGN="CENTER" VALIGN="MIDDLE" hidden>
            <div align="center" >
            <img src="<?php echo $res ?> " class='image_report' style="float:left; max-width: 100px; width:100px;" class='image_report'> 
            </div>
        </TD>
        <TD WIDTH="60%" align="center" style="text-align:center;">
            <div align="center" class="nama_profil" style="color: black !important; ">
                <p style="text-align:center;"><?php echo $konfig->alamatheadersurat; ?></p>
            </div>
        </TD>
        <?php if (file_exists($path2)): ?>
        <TD WIDTH="20%" ALIGN="CENTER" VALIGN="MIDDLE" hidden>
            <img src="<?php echo $res2 ?> "  class='image_report' style="float:left; max-width: 100px; width:100px;" class='image_report'>
        </TD>
        <?php endif; ?>
    </TR>
    <tr>
        <td colspan="3" ></td>
    </tr>
     <TR>
        <TD  ALIGN=CENTER VALIGN=MIDDLE class="" colspan="3">
            <div align="center" >
                <h3><?php echo $judulLaporan ?? 'LAPORAN PEMBAYARAN KASIR'; ?></h3>
            </div>
        </TD>
    </TR>
    <TR>
       <TD  ALIGN=CENTER VALIGN=MIDDLE class="" colspan="3">
            <div align="center" >

              <font color="black">
              <?php echo empty($billing) ? "" : ($billing.", "); ?>
              <?php echo "Periode " . (isset($periode) ? $periode : '') ?></font>
            </div>
        </TD>
    </TR>

</table>

