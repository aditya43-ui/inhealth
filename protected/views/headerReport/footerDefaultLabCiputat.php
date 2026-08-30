<?php
// $profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
// $alamat = !empty($profil->alamatlokasi_rumahsakit) ? $profil->alamatlokasi_rumahsakit : "";
// $motto = !empty($profil->motto) ? $profil->motto : "";
// $telp = !empty($profil->no_telp_profilrs) ? $profil->no_telp_profilrs : "";
// $email = !empty($profil->email) ? $profil->email : "";
// $website = !empty($profil->website) ? $profil->website : "";
$author = "Authorized by:";
$suplogo = "Hasil sudah divalidasi secara elektronik tidak perlu tanda tangan";
?>
<table width="100%" class="footer">
        <tr>
                <td width="30%"></td>
                <td width="40%" style="text-align:center" align="center" class="">
                        <?php //echo  $suplogo ?>
                        <img src="images/images_footer.png" style="height:35px;"/>
                </td>
                <td class="" style="text-align:right" width="30%" align="right">
                        <?php
                        $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState("pegawai_id"));

                        if (!empty($peg)) {
                                echo $author. ' ' .$peg->namaLengkap. ' ' .(date('d/m/Y H.i'));
                        } else {
                                //echo Yii::app()->user->getState("nama_pegawai"); 
                        } ?>
                </td>
        </tr>

</table>