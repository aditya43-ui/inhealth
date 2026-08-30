<?php
    $tindakan = InsidenrsdetT::model()->findByAttributes(array("insidenrs_id"=>$insidenrs_id));  
    if (!empty($tindakan->subtipeinsiden->tipeinsiden->tipeinsiden_nama)){
        echo $tindakan->subtipeinsiden->tipeinsiden->tipeinsiden_nama;
    }
?>