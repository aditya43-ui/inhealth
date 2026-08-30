<style>
  .nama_profil {
    font-size: 12pt;
    font-weight: bold;
  }
</style>


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


?>
<table width="<?php echo ((isset($width)) ? $width : "100%") ?>" class="headers table-header">
    
    <!--<TD width="15%" height="50%">-->
    <TR>
        <TD WIDTH="20%" ALIGN="CENTER" VALIGN="MIDDLE" >
            <div align="center" >
            <img src="<?php echo $res ?> " class='image_report' style="float:left; max-width: 100px; width:100px;" class='image_report'> 
            </div>
        </TD>
        <TD align="right" style="text-align:right;">
            <div align="right" class="nama_profil" style="color: black !important; ">
                <?php 
                $header = strip_tags($konfig->alamatheadersurat, "<br>");
                
                echo $header;
                echo "<br/>";
                echo "Telp : ".$data->no_telp_profilrs.", Fax : ".(empty($data->no_faksimili) ? "-" : $data->no_faksimili) ?>
            </div>
        </TD>
        
    </TR>
    <tr>
        <td colspan="2" style="border-top: 1px solid black;"></td>
    </tr>

</table>

