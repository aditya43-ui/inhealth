<?php
    if(!empty($id))
    {
        echo "<ul>";
        foreach (TariftindakanM::model()->findAllByAttributes(array('daftartindakan_id'=>$id)) as $i => $tindTarif) 
        {
            echo '<li>'.KomponentarifM::model()->findByPk($tindTarif['komponentarif_id'])->komponentarif_nama.'</li>';
        }
        echo "</ul>";
    }
    else
    {
        echo "Belum di Set";
    }
?>
