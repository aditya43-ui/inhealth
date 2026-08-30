<?php $data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();
?>
<table width="100%" class="tableHead">
    <tr>
        <td style="text-align: center;">
            <img src="<?php echo Yii::app()->baseUrl.'/images/logo-rspmc-transparan.png'; ?> " width="400px"/>
        </td>
    </tr>
    <tr>
        <td style="text-align: center; border-bottom: 2px solid #000;">
            <?php echo $konfig->alamatheadersurat; ?>
            <!--Jalan Raya Maos-Sampang, Kelurahan Karangtengah, Kecamatan Sampang, Kabupaten Cilacap--> 
            <br>
            <br>
        </td>
    </tr>
</table>
<br>