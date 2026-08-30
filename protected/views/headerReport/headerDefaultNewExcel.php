
<?php 
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
$konfig = KonfigsystemK::model()->find();

$path = Params::pathProfilRSDirectory().$data->logo_rumahsakit;
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
<table width="100%" >
    <thead>
        <TR>
            <TH WIDTH=80 ALIGN=CENTER VALIGN=MIDDLE>
                
                <img src="<?php echo $res ?>" width ="80" align="center" style="float:left;" class='image_report'/>
               
            </TH>
            <TH ALIGN=CENTER VALIGN=MIDDLE colspan=" <?php echo (!empty($colspan)) ? ($colspan-1) : "5"; ?>" nowrap>
                <?php echo $konfig->alamatheadersurat; ?>
            </TH>
            <TH rowspan="4" WIDTH="80" ALIGN="CENTER" VALIGN="MIDDLE">
               <?php 
                    $caraPrint = isset($_GET['caraPrint'])?$_GET['caraPrint']:null; 
                    
                ?>
                <img src="<?php echo $res2 ?>" height ="80"  align="center" style="float:left;" class='image_report'/>
            </TH>
        </TR>
         <TR>
            <TD colspan=" <?php echo ((!empty($colspan)) ? ($colspan) : 6) + 1; ?>" HEIGHT=2 style="border-bottom: 2px solid #000000" ></TD>
        </TR>
        <?php
            if(isset($judulLaporan) || strlen($judulLaporan) > 0){
        ?>
            <TR>
                <TD colspan=" <?php echo ((!empty($colspan)) ? ($colspan) : 6) + 1; ?>" ALIGN=CENTER VALIGN=MIDDLE ><font color="black"><h3><?php echo $judulLaporan ?></h3></font></TD>
            </TR>
        <?php
            }
        ?>
        <?php
            $periode = (isset($periode) ? $periode : null);
            if(isset($periode) || strlen($periode) > 0){
        ?>
            <TR>
                <TD colspan=" <?php echo ((!empty($colspan)) ? ($colspan) : 6) + 1; ?>" ALIGN=CENTER VALIGN=MIDDLE><font color="black" style='font-size:11px'><?php echo $periode ?></font></TD>
            </TR>  
        <?php
            }
        ?>
            </thead>
</table>
