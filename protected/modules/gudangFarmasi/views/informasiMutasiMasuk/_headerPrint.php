<?php
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();

$path2 = Params::pathProfilRSDirectory().$data->logo_rumahsakit_2;

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
<table width="<?php echo ((isset($width)) ? $width : "100%") ?>" class="headers">

    <!--<td width="15%" height="50%">-->
    <tr>
        <td ALIGN=CENTER VALIGN=MIDDLE class="logo_profil">
            <div style="text-align: center;">
                <img src="<?php echo //'data:image/png;base64,'.base64_encode(file_get_contents(Params::urlProfilRSDirectory().$data->logo_rumahsakit_2)); 
                                        $res2
                                    ?> " style="height:1.3cm;width:6.5cm;" class='image_report'/>
            </div>
        </td>
    </tr>
     <tr>
        <td ALIGN=CENTER VALIGN=MIDDLE class="">
            <div style="text-align: center;">
                <h3><?php echo ((isset($judulLaporan)) ? $judulLaporan : null); ?></h3>
            </div>
        </td>
    </tr>
    <tr>
        <td>
        <!--Untuk space agar tidak mepet-->
        &nbsp;
        </td>
    </tr>

</table>
