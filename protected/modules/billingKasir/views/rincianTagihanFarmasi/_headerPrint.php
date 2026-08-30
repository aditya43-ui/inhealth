<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td width="25%" align="center">
            <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " style="max-width: 100px; width:100px;"/>
        </td>
        <td align="center" nowrap>            
            <div>
                <b><?php echo $modProfilRs->nama_rumahsakit; ?></b>
            </div>
            <div>
                <?php echo $modProfilRs->alamatlokasi_rumahsakit; ?>
            </div>
            <div>
                Telp. <?php echo $modProfilRs->no_telp_profilrs; ?> / Fax. <?php echo $modProfilRs->no_faksimili; ?> - <?php echo $modProfilRs->website; ?>
            </div>
        </td>
        <td width="25%" align="center">
            &nbsp;
        </td>
    </tr>
    <tr>
        <td colspan="3" style="border-bottom: 2px solid #000000">&nbsp;</td>
    </tr>
</table>