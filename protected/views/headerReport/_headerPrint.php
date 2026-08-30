<?php
/*
 * id pada attribute iamge digunakan untuk pengaturan header di halaman lain
 */
?>
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<table width="100%" border="0px">
    <tr>
        <td width="25%" align="center" >
            <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " id="headerset2" style="max-width: 80px; width:80px;"/>
        </td>
        <td align="center">
            <div>
                <b><?php echo strtoupper($modProfilRs->namakepemilikanrs); echo ' '.strtoupper($modProfilRs->propinsi->propinsi_nama); ?></b>
            </div>
            <div>
                <b><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></b>
            </div>
            <div>
                <?php echo $modProfilRs->alamatlokasi_rumahsakit; ?>
            </div>
        </td>
        <td width="25%" align="center">
            
            
        </td>
    </tr>
    
</table>
