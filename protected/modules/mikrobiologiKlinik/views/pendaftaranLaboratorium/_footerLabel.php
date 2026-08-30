

<?php

$profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$alamat = !empty($profil->alamatlokasi_rumahsakit) ? $profil->alamatlokasi_rumahsakit : "";
$motto = !empty($profil->motto) ? $profil->motto : "";
$telp = !empty($profil->no_telp_profilrs) ? $profil->no_telp_profilrs : "";
$email = !empty($profil->email) ? $profil->email : "";
$website = !empty($profil->website) ? $profil->website : "";
$layoutkiri = $alamat . "<br>" . "Telp:" . $telp . " Email:" . $email . " Website:" . $website;

echo '<div  class="footer"><table ><tr><td class="alamatfooter_small">'.$layoutkiri.'</td><td class="mottofooter_small">'.$motto.'</td></tr></table></div>';
