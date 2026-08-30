<?php 
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();
?>
<table width="100%">
    <tr>
        <td align="center"  colspan="<?php echo isset($colspan)?$colspan:10; ?>">            
            <div>
                <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit_2 ?> " class='image_report'/>
            </div>          
        </td>
    </tr>
	<tr>       
        <td align="center"  colspan="<?php echo isset($colspan)?$colspan:10; ?>">                       
            <div>
                <?php echo $konfig->alamatheadersurat; ?>
            </div>           
        </td>       
    </tr>
    <?php /*
	<tr>       
        <td align="center"  colspan="<?php echo (isset($colspan)?$colspan:'10') ?>">                       
            <div>
                Telp. <?php echo $modProfilRs->no_telp_profilrs; ?> / Fax. <?php echo $modProfilRs->no_faksimili; ?> - <?php echo $modProfilRs->website; ?>
            </div>
        </td>       
    </tr>
     * 
     */ ?>  
    <tr>
        <td colspan="<?php echo ($caraPrint=='EXCEL')?((isset($colspan)?$colspan:'12')):'3' ?>" style="border-bottom: 2px solid #000000">&nbsp;</td>
    </tr>
</table>