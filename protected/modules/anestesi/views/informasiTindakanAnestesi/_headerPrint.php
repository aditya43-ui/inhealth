<?php
/*
 * id pada attribute iamge digunakan untuk pengaturan header di halaman lain
 */
?>
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<table width="100%" border="0px">
    <tr>
        <td width="25%" align="center" >
            <img src="<?php echo Params::pathImageErrorAdmin()."Jawa_Timur.png"?> " id="headerset" style="max-width: 80px; width:80px;"/>
        </td>
        <td align="center" style="">
            <div style="font-size:8pt">
                <?php echo strtoupper($modProfilRs->namakepemilikanrs); echo ' '.strtoupper($modProfilRs->propinsi->propinsi_nama); ?>
            </div>
            <div style="font-size:15pt">
                <b><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></b>
            </div>
            <div style="font-size:7pt">
                <?php echo $modProfilRs->alamatlokasi_rumahsakit." Surabaya"; ?>
            </div>
        </td>
        <td width="25%" align="center">
            
            <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " id="headerset2" style="max-width: 80px; width:80px;"/>
        </td>
    </tr>
    
</table>
