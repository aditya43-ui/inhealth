<?php
$criteria = new CDbCriteria;
    $criteria->select = 'tindakankomponen_t.komponentarif_id, t.tarif_tindakan,t.pendaftaran_id, t.ruangan_id,t.tgl_pendaftaran,t.pegawai_id';
    if($pendaftaran_id == null || $ruangan_id == null || $tgl_pendaftaran == null){
         $criteria->compare('t.pegawai_id',$pegawai_id);
    }else{
        $criteria->compare('t.pendaftaran_id',$pendaftaran_id);
        $criteria->compare('t.ruangan_id',$ruangan_id);
        $criteria->compare('t.tgl_pendaftaran',$tgl_pendaftaran);
    }
    $criteria->join = 'LEFT JOIN tindakanpelayanan_t ON t.tindakanpelayanan_id = tindakanpelayanan_t.tindakanpelayanan_id LEFT JOIN tindakankomponen_t ON tindakankomponen_t.tindakanpelayanan_id = t.tindakanpelayanan_id';
    
    
//    $modTarif = LaporanrekaptransaksiV::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'ruangan_id'=>$ruangan_id,'tgl_pendaftaran'=>$tgl_pendaftaran));
    $modTarif = LaporanrekaptransaksiV::model()->findAll($criteria);
    $totTarif = 0;
    
    foreach($modTarif as $key=>$tarif){
       if($tarif->komponentarif_id == 26){
           $totTarif += $tarif->tarif_tindakan;
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
   echo number_format($totTarif);
?>