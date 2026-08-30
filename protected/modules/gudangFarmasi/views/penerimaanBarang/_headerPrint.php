<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
$konfigSys = KonfigsystemK::model()->find();
?>
<table width="100%">
    <tr>
        <td width="25%" align="center">
            <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " style="max-width: 80px; width:80px;"/>
        </td>
        <td align="center">
            <div hidden>
                <b><?php // echo strtoupper($modProfilRs->namakepemilikanrs); ?></b>
                <!--<b>PEMERINTAH PROPINSI <?php // echo strtoupper($modProfilRs->propinsi->propinsi_nama); ?></b>-->
            </div>
            <div style="font-size: 12pt">
                <b><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></b>
            </div>
            <div>
                <?php echo $konfigSys->alamatheadersurat; ?>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="border-bottom: 2px solid #000000">&nbsp;</td>
    </tr>
</table>