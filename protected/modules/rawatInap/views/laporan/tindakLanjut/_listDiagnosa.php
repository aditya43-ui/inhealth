<?php
    $tindakan = RILaporantindaklanjutri::model()->findAll(" pendaftaran_id = '".$pendaftaran_id."' ");        
    
    if (count((array)$tindakan)>0){
        echo "<ul>";
        foreach($tindakan as $dt){
            if (!empty($dt->diagnosa_nama)){
                echo "<li>".$dt->diagnosa_nama."</li>";
            }
        }
        echo "</ul>";
    }else{
        echo "-";
    }
?>