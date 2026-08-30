<style>
    body{
        line-height: 16pt;
    }
</style>
<?php $data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<table width="100%" border="0px">
    <tr>
        <td width="10%" align="left" >
            <img src="<?php echo Params::pathImageErrorAdmin()."Jawa_Timur.png"?> " id="headerset" style="max-width: 80px; width:80px;"/>
        </td>
        <td align="center">
            <div style="font-size: 11pt">
                <b><?php echo strtoupper($data->namakepemilikanrs); echo ' '.strtoupper($data->propinsi->propinsi_nama); ?></b>
            </div>
            <div style="font-size: 12pt">
                <b>RUMAH SAKIT UMUM DAERAH Dr. SOETOMO</b>
            </div>
            <div style="font-style: italic; font-size: 9pt">
                <?php echo $data->alamatlokasi_rumahsakit.', Telp. '.$data->no_telp_profilrs.', Fax. '.$data->no_faksimili.', 50287'; ?>
            </div>
            <div style="font-size: 11pt">
                <b><u>SURABAYA - 60286</u></b>
            </div>
        </td>
        <td width="10%" align="right">
            <img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit ?> " id="headerset2" style="max-width: 80px; width:80px;"/>
        </td>
    </tr>
    
</table>
