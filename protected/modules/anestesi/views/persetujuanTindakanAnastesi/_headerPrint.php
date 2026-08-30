<?php
/*
 * id pada attribute iamge digunakan untuk pengaturan header di halaman lain
 */
?>
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<?php if($_GET['caraprint'] == 'PDF') { ?>
<table width="50%" border="0px">
    <tr>
        <td width="17%" align="center" >
            <img src="<?php echo Params::pathImageErrorAdmin()."Jawa_Timur.png"?> " id="headerset" style="max-width: 80px; width:80px;"/>
        </td>
        <td align="center">
            <div>
                <h4><?php echo strtoupper($modProfilRs->namakepemilikanrs); echo ' '.strtoupper($modProfilRs->propinsi->propinsi_nama); ?></h4>
            </div>
            <div>
                <h3><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></h3>
            </div>
            <div>
                <h4><?php echo $modProfilRs->alamatlokasi_rumahsakit; ?> Surabaya</h4>
            </div>
        </td>
        <td width="17%" align="center">
            <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " id="headerset2" style="max-width: 80px; width:80px;"/>
        </td>
    </tr>
    
</table>

<?php }else{ ?>
<table width="100%" border="0px">
    <tr>
        <td width="15%" align="center" >
            <img src="<?php echo Params::pathImageErrorAdmin()."Jawa_Timur.png"?> " id="headerset" style="max-width: 80px; width:80px;"/>
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
        <td width="15%" align="center">
            <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " id="headerset2" style="max-width: 80px; width:80px;"/>
        </td>
    </tr>
    
</table>
<?php } ?>