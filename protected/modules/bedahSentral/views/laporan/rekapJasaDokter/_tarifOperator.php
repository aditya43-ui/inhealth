<?php
    $criteria = new CDbCriteria;
    $criteria->select = 'komponentarif_id, tarif_tindakankomp, pendaftaran_id, ruangan_id, tgl_pendaftaran,pegawai_id';
    if($pendaftaran_id == null || $ruangan_id == null || $tgl_pendaftaran == null){
        if (isset($pegawai_id)){
			if (!empty($pegawai_id)){
				$criteria->addCondition('pegawai_id = '.$pegawai_id);
			}
        }
    }else{
		if (!empty($pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
		}
		if (!empty($ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$ruangan_id);
		}
		if (!empty($tgl_pendaftaran)){
			$criteria->addCondition('tgl_pendaftaran = '.$tgl_pendaftaran);
		}
    }
    $modTarif = LaporantindakankomponenV::model()->findAll($criteria);
    $totTarif = 0;
    
    foreach($modTarif as $key=>$tarif){
       if($tarif->komponentarif_id == 21){
           $totTarif += $tarif->tarif_tindakankomp;
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