<?php
$criteria = new CDbCriteria;
    $criteria->select = 'zatbahanmakan_m.bahanmakanan_id, t.bahanmakanan_id, zatbahanmakan_m.zatgizi_id,zatbahanmakan_m.kandunganbahan,zatgizi_m.zatgizi_id';
    
    if (empty($zatgizi_id)){
        $zatgizi_id = null;
    }
    
    if($bahanmakanan_id == null || $zatgizi_id == null){
         $criteria->compare('zatbahanmakan_m.bahanmakanan_id',$bahanmakanan_id);
    }else{
        $criteria->compare('zatbahanmakan_m.bahanmakanan_id',$bahanmakanan_id);
        $criteria->compare('zatbahanmakan_m.zatgizi_id',$zatgizi_id);
    }
    $criteria->join = 'LEFT JOIN zatbahanmakan_m ON t.bahanmakanan_id = zatbahanmakan_m.bahanmakanan_id LEFT JOIN zatgizi_m ON zatbahanmakan_m.zatgizi_id = zatgizi_m.zatgizi_id';
    
    $modKandunganBahan = GZZatBahanMakananM::model()->findAll($criteria);
    $totKandunganBahan = 0;
    
    foreach($modKandunganBahan as $key=>$kandunganBahan){
       if($kandunganBahan->zatgizi_id == 6){
           $totKandunganBahan = $kandunganBahan->kandunganbahan;
           /*
           if($totTarif == null){
               echo "0";
           }else{
               echo $totTarif;
           }
            * 
            */
       }else{
//           echo "0";
           
       }
   }
   echo ($totKandunganBahan);
?>