<ul>
<?php
$modKelasRuangan = KelasruanganM::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id));
foreach ($modKelasRuangan as $row){
    echo '<li>'.$row->kelaspelayanan->kelaspelayanan_nama.'</li>';
}
?>

    </ul>