<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
</style>

    <table>
        <tr>
            <td>
                <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
            </td>
        </tr>
    </table>
    <table class="status">
         <tr>
            <td align="center" valig="middle" colspan="3">
                 Data Barang
            </td>
        </tr>

        <tr>
            <td>Kode Barang</td>
            <td>:</td>
            <td><?php echo $model->barang_kode; ?></td>
        </tr>
        <tr>
            <td>Nama Barang</td>
            <td>:</td>
            <td><?php echo $model->barang_nama; ?></td>
        </tr>
        <tr>
            <td>Bahan Barang</td>
            <td>:</td>
            <td><?php echo isset($model->barang_bahan)? $model->barang_bahan : ""; ?></td>
        </tr>
        <tr>
            <td>Satuan Barang</td>
            <td>:</td>
            <td><?php echo isset($model->barang_satuan)? $model->barang_satuan : ""; ?></td>
        </tr>
    </table>
<br>
    <div style="border: 0 solid;margin-left: 20px; margin-top: 40px;text-align:center;width:200px;">
        <img src="index.php?r=barcode/myBarcode&code=<?php echo $model->barang_id; ?>&is_text=" style="transform:scale(2.0)">
    </div>
<?php 
$profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
        $alamat=!empty($profil->alamatlokasi_rumahsakit)?$profil->alamatlokasi_rumahsakit:"";
	$motto=!empty($profil->motto)?$profil->motto:"";
        $telp=!empty($profil->no_telp_profilrs)?$profil->no_telp_profilrs:"";
        $email=!empty($profil->email)?$profil->email:"";
        $website=!empty($profil->website)?$profil->website:"";
        $layoutkiri=$alamat."<br>"."Telp:".$telp." Email:".$email." Website:".$website;
?>
<table width="100%" class="footer">
    <tr><td width="70%" style="text-align:left" align="left" class="alamatfooter"><?php echo  $layoutkiri ?></td><td class="mottofooter" style="text-align:right"  width="30%" align="right"><?php echo $motto ?></td></tr>
        
</table>
