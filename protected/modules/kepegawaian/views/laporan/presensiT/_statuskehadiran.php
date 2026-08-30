<?php
//    $modStatuspresensi = PresensiT::model()->findByAttributes(array('karyawan_id'=>$karyawan_id, 'statusscan_id'=>$statusscan_id, 'date(tglpresensi)'=>'2012-10-09 08:23:09'));
//    $modStatuspresensi = PresensiT::model()->find("pegawai_id=$pegawai_id AND DATE(tglpresensi)='$datepresensi' AND statuskehadiran_id is NOT NULL");
    
    //$modStatuskehadiran = StatuskehadiranM::model()->findByPK($statuskehadiran_id);
    //if (!empty($modStatuskehadiran))
   // {
    //    echo $modStatuskehadiran->statuskehadiran_nama;
   // } else {
    //    echo "-";
    //}
                               $cr4 = new CDbCriteria();
                               $cr4->compare('tglpresensi::date', $datepresensi);
                               $cr4->compare('pegawai_id', $pegawai_id);                            
                               $cr4->addCondition('statusscan_id=:p1');
                               //$cr4->addCondition('statuskehadiran_id IN(:p2)');
                               $cr4->params[':p1'] = Params::STATUSSCAN_MASUK;
                               //$cr4->params[':p2'] = Params::getKehadiranTanpaHadir();
                               $pr4 = PresensiT::model()->find($cr4);
                               

                               $cr5 = new CDbCriteria();
                               $cr5->compare('tglpresensi::date', $datepresensi);
                               $cr5->compare('pegawai_id', $pegawai_id);                            
                               $cr5->addCondition('statusscan_id=:p1');
                               //$cr5->addCondition('statuskehadiran_id IN(:p2)');
                               $cr5->params[':p1'] = Params::STATUSSCAN_PULANG;
                               //$cr5->params[':p2'] = Params::getKehadiranTanpaHadir();
                               $pr5 = PresensiT::model()->find($cr5);
                               
                               /*if (count((array)$pr4)>0){
                                   $waktu = date('H:i:s', strtotime($pr4->tglpresensi));
                                   if ( ($waktu >= '09:00:00') AND ($waktu <= '10:00:00')){
                                        echo StatuskehadiranM::model()->findByPk(Params::STATUSKEHADIRAN_ALPHA)->statuskehadiran_nama;
                                    }else{
                                        echo $pr4->statuskehadiran->statuskehadiran_nama;
                                    }                                    
                               }else{
                                   if (count((array)$pr5)){                                       
                                       echo $pr5->statuskehadiran->statuskehadiran_nama;
                                   }else{
                                       echo '-';
                                   }
                               }*/
                               
                               $masuk = !empty($pr4)?strtotime($pr4->tglpresensi):null;
                                $pulang = !empty($pr5)?strtotime($pr5->tglpresensi):null;

                                 if ( (!empty(Params::getStatusHadir(!empty($pr5->statuskehadiran_id)?$pr5->statuskehadiran_id:null)) || (!empty(Params::getStatusHadir(!empty($pr4->statuskehadiran_id)?$pr4->statuskehadiran_id:null)))) ){                                     
                                     if (!empty(Params::getStatusHadir(!empty($pr4->statuskehadiran_id)?$pr4->statuskehadiran_id:null))){
                                         echo PresensiT::model()->getWarnaKehadiran($pr4->statuskehadiran->statuskehadiran_nama);
                                     }elseif (!empty(Params::getStatusHadir(!empty($pr5->statuskehadiran_id)?$pr5->statuskehadiran_id:null))){
                                         echo PresensiT::model()->getWarnaKehadiran($pr5->statuskehadiran->statuskehadiran_nama);
                                     }
                                 }else{
                                     if ( (empty($masuk)) && (empty($pulang)) ){
                                         echo 'Tidak ada absen masuk/pulang';
                                     }elseif ( (!empty($masuk)) && (empty($pulang)) ){
                                         echo 'Tidak ada absen pulang';
                                     }elseif ( (empty($masuk)) && (!empty($pulang)) ){
                                         echo 'Tidak ada absen masuk';
                                     }else{
                                          $jam = floor(round(abs($masuk - $pulang) / 60,2)/60);

                                          if ($jam >= Params::KUOTA_JAM_KERJA){
                                              echo PresensiT::model()->getWarnaKehadiran(Params::STATUSKEHADIRAN_NAMA_HADIR);
                                          }else{
                                              echo PresensiT::model()->getWarnaKehadiran(Params::STATUSKEHADIRAN_NAMA_ALPHA);
                                          }
                                     }
                                 }
?>