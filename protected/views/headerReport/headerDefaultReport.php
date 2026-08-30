<?php 
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
$konfig = KonfigsystemK::model()->find(); 
?>
<div align="left" style="margin-left:80px;"><?php echo date('d/m/Y. H:i A'); ?></div>
<div align="right" style="margin-right:270px;"> <?php echo 'Laporan'; ?></div>
   <table class="line no-border" width="45%">
    <tr>
        <td class="line no-border" width="70" align="left">
            <img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit ?> " style="float:left; max-width: 90px; width:90px;" width="100" class='image_report'/>
        </td>
        <td align="center">
            <div>
                <FONT FACE="Liberation Serif" color="black"><?php echo $konfig->alamatheadersurat; ?></FONT>
            </div>
        </td>
        <td class="line no-border" width="70" align="right">
        <img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit_2 ?> " style="float:left; max-width: 90px; width:90px;" width="100" class='image_report'/>
        </td>
    </tr>

   
</table>