<?php

    $criteria = new CDbCriteria;
    $criteria->select = 'tindakankomponen_t.komponentarif_id,t.daftartindakan_tindakan, t.daftartindakan_konsul, t.daftartindakan_visite, t.daftartindakan_karcis,
                        t.tarif_tindakan,t.pendaftaran_id, t.ruangan_id, t.tgl_pendaftaran,t.pegawai_id';
    if($pendaftaran_id == null || $ruangan_id == null || $tgl_pendaftaran == null){
		if(!empty($pegawai_id)){
			$criteria->addCondition("t.pegawai_id = ".$pegawai_id);			
		}
    }else{
		if(!empty($pendaftaran_id)){
			$criteria->addCondition("t.pendaftaran_id = ".$pendaftaran_id);			
		}
		if(!empty($ruangan_id)){
			$criteria->addCondition("t.ruangan_id = ".$ruangan_id);			
		}
		if(!empty($tgl_pendaftaran)){
			$criteria->addCondition("DATE(t.tgl_pendaftaran) = '".$tgl_pendaftaran."'"); 		
		}
    }
    $criteria->join = 'LEFT JOIN tindakanpelayanan_t ON t.tindakanpelayanan_id = tindakanpelayanan_t.tindakanpelayanan_id LEFT JOIN tindakankomponen_t ON tindakankomponen_t.tindakanpelayanan_id = t.tindakanpelayanan_id';
    
    
//    $modTarif = LaporanrekaptransaksiV::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'ruangan_id'=>$ruangan_id,'tgl_pendaftaran'=>$tgl_pendaftaran));
    $modTarif = LaporanrekaptransaksiV::model()->findAll($criteria);
    $totTarif = 0;
    
    foreach($modTarif as $key=>$tarif){
       if($tarif->daftartindakan_visite == true  || $tarif->daftartindakan_konsul == true || $tarif->daftartindakan_tindakan == true || $tarif->komponentarif_id == 15 || $tarif->komponentarif_id == 26 || $tarif->komponentarif_id == 21){
           $totTarif = $totTarif + $tarif->tarif_tindakan;
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
   echo "Rp".number_format($totTarif,0,"",".");
?>