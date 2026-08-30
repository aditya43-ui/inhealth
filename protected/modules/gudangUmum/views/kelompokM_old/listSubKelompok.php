<?php

$modSubKelompok = SubkelompokM::model()->findAllByAttributes(array('kelompok_id' => $idKelompok));
echo '<ul>';
foreach ($modSubKelompok as $row){
    echo '<li>'.$row->subkelompok_nama.'</li>';
}
echo '</ul>';
?>
