<?php
    $tindakan = InsidenrsdetT::model()->findAll(" insidenrs_id = '".$insidenrs_id."' ");        
    
    if (count($tindakan)>0){
        foreach($tindakan as $dt){
            if (!empty($dt->subtipeinsiden_id)){
                echo $dt->subtipeinsiden->subtipeinsiden_nama.', <br>';
            }
        }
    }else{
        echo "-";
    }
?>