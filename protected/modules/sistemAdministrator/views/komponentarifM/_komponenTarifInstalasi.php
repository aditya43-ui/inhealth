<?php
$modKomponenTarifInstalasi=KomponentarifinstalasiM::model()->with('instalasi')->findAll('komponentarif_id='.$komponentarif_id.'');
if(count((array)$modKomponenTarifInstalasi)>0)
    {
        echo "<ul>";
        foreach($modKomponenTarifInstalasi as $i=>$ruangan)
        {
            echo '<li>'.$ruangan->instalasi->instalasi_nama.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo "Belum di Set";
    }   
?>

