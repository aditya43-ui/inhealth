<?php
$modKelasRuangan=KelasruanganM::model()->with('kelaspelayanan')->findAll('ruangan_id='.$ruangan_id.'');
if(count((array)$modKelasRuangan)>0)
    {
        echo "<ul>";
        foreach($modKelasRuangan as $i=>$ruangan)
        {
            echo '<li>'.$ruangan->kelaspelayanan->kelaspelayanan_nama.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo "Belum di Set";
    }   
?>

