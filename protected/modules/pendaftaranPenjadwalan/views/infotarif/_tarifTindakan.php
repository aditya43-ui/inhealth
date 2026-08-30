<?php
$modTarifTindakan=  PPTariftindakanM::model()->with('komponentarif')->findAllByAttributes(array('komponentarif_id'=>$komponentarif_id));
if(count((array)$modTarifTindakan)>0)
    {
        echo "<ul>";
        foreach($modTarifTindakan as $i=>$ruangan)
        {
            echo '<li>'.$ruangan->komponentarif->komponentarif_nama.'</li>';
            echo '<li>'.$ruangan->harga_tariftindakan.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo "Belum di Set";
    }   
?>