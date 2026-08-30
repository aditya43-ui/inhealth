<?php
    $tindakan = LampiransuratsehatR::model()->findAll(" suratketerangan_id = '".$suratketerangan_id."' ");        
    
    if (count((array)$tindakan)>0){
//        echo "<ul>";
        foreach($tindakan as $dt){
            if (!empty($dt->lampiransuratsehat_nama)){
                echo $dt->lampiransuratsehat_nama.', <br>';
            }
        }
//        echo "</ul>";
    }else{
        echo "-";
    }
?>