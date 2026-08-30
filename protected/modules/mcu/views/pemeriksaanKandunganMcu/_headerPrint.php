
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<table width="100%" border="0px">
    <tr>
        <td width="25%" align="center">
            <img src="<?php echo Params::pathImageErrorAdmin()."Jawa_Timur.png"?> " style="max-width: 80px; width:80px;"/>
        </td>
        <td align="center">
            <div>
                <b><?php echo strtoupper($modProfilRs->namakepemilikanrs); echo strtoupper($modProfilRs->propinsi->propinsi_nama); ?></b>
            </div>
            <div>
                <b><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></b>
            </div>
            <div>
                <?php echo $modProfilRs->alamatlokasi_rumahsakit; ?>
            </div>
        </td>
        <td width="25%" align="center">
            <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " style="max-width: 1100px; width:110px;"/>
        </td>
    </tr>
    
</table>
