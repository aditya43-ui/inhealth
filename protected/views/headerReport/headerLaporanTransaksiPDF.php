<?php 
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find(); 


$path = Params::pathProfilRSDirectory().$data->logo_rumahsakit;

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
<table width="100%">
        <TR>
            <TD ROWSPAN="2" WIDTH="80" ALIGN="CENTER" VALIGN="MIDDLE">
                <?php 
                    $caraPrint = isset($_GET['caraPrint'])?$_GET['caraPrint']:null; 
                    
                    if ($caraPrint == 'PDF'){
                ?>
                <img src="<?php echo $res ?> " style="float:left; max-width: 100px; width:100px;" class='image_report'/>
                    <?php }else{ ?>
                    <img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit ?> " style="float:left; max-width: 100px; width:100px;" class='image_report'/>
                 
                 <?php } ?>
            </TD>
            <TD ALIGN="CENTER" VALIGN="MIDDLE" colspan=" <?php echo (!empty($colspan)) ? ($colspan-1) : "5"; ?>" nowrap>
                <?php echo $konfig->alamatheadersurat; ?>
            </TD>
            <TD ROWSPAN="3" rowspan="3" WIDTH="80" ALIGN="CENTER" VALIGN="MIDDLE">
                &nbsp;
            </TD>
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
</table>
