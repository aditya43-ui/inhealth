<?php $data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<table width="100%" id="headerlaporan">
    <tr>
        <td style="text-align: center">
            <img src="<?php echo Yii::app()->getBaseUrl('webroot') . '/data/images/Jawa_Timur.png'; ?> " style="float:left; max-width: 80px; width:80px;" class='image_report'/>
        </td>
        <td style="text-align: center; font-size: 12px; font-family: Arial" >
            PEMERINTAH PROVINSI JAWA TIMUR<br>
            <b> RUMAH SAKIT UMUM Dr. SOETOMO </b><br>
            Nomor : <?php echo $modMutasi->nomutasiaset; ?><br>
            <b> GUDANG RUMAH SAKIT UMUM DAERAH Dr. SOETOMO </b><br>
            <b> BUKTI BARANG DARI : SUB BAG PERLENGKAPAN </b><br>
            <b style="text-transform: uppercase"> KEPADA :  <?php echo CHtml::encode($modMutasi->ruangantujuan->ruangan_nama); ?>  </b>
        </td>
        <td style="text-align: center">
            <img src="<?php echo Params::urlProfilRSDirectory() . $data->logo_rumahsakit ?> " style="float:left; max-width: 90px; width:90px;" class='image_report'/>
        </td>
    </tr>
</table>

<table width="100%">
    <TR>
        <TD HEIGHT=2 style="border-bottom: 2px solid #000000; margin-bottom: 20px">&nbsp;</TD>
    </TR>
</table>