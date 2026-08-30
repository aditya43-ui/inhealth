<?php

$modGolongan = KelompokM::model()->findAllByAttributes(array('kelompok_id' => $idKelompok));
echo '<ul>';
foreach ($modGolongan as $row){
    echo '<li>'.$row->golongan_id.'</li>';
}
echo '</ul>';
?>
