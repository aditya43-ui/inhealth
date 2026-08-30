<?php
    $format = new MyFormatter();
    $cr = new CDbCriteria();                            
    $cr->addBetweenCondition('tglpresensi', $format->formatDateTimeForDb($tgl_awal), $format->formatDateTimeForDb($tgl_akhir));    
    $cr->compare('pegawai_id', $pegawai_id);
    $cr->addCondition('statusscan_id=:p1');
    $cr->params[':p1'] = $statusscan_id;
    $pr = PresensiT::model()->findAll($cr);
     $shift = KPPresensiT::model()->getShiftId($pegawai_id);
       
    if (empty($pr)){echo "-";
    }else{         
        $total = 0;
        
        foreach ($pr as $pr):    
            $jamM = null;
            $jamP = null;
            $tgl = MyFormatter::formatDateTimeForDb(date('Y-m-d',  strtotime($pr->tglpresensi)));
            $cekJadwal = PenjadwalandetailT::model()->cekPenjadwalan($pegawai_id, $pr->tglpresensi);
            $cekPertukaran = PertukaranjadwaldetT::model()->cekPertukaran($pegawai_id, $pr->tglpresensi);
            $jammasuk = PresensiT::model()->getJam(Params::STATUSSCAN_MASUK, $pr->tglpresensi, $pegawai_id);
            $jampulang = PresensiT::model()->getJam(Params::STATUSSCAN_PULANG, $pr->tglpresensi, $pegawai_id);
            $masuk = PresensiT::model()->findAll(" statusscan_id = '".Params::STATUSSCAN_MASUK."' AND tglpresensi::text iLike '$tgl%' AND pegawai_id = '$pegawai_id' ");

            if (count((array)$masuk)>0)
            {
                foreach($masuk as $masuk):
                    $jamM = $masuk->tglpresensi;
                endforeach;
            }
            $pulang = PresensiT::model()->findAll(" statusscan_id = '".Params::STATUSSCAN_PULANG."' AND tglpresensi::text iLike '$tgl%' AND pegawai_id = '$pegawai_id' ");

            if (count((array)$pulang) > 0 )
            {
                foreach($pulang as $pulang):
                    $jamP = $pulang->tglpresensi;
                endforeach;
            }

            if($cekPertukaran == 0)
            {
                if ($cekJadwal == 0){
                        if (isset($data->pegawai->shift_id)){                                               
                            if ($data->pegawai->shift_id == Params::SHIFT_PAGI){
                                $tepat = strtotime(date('Y-m-d',strtotime($pr->tglpresensi))." 08:15:00");
                            }else{
                                $tepat = strtotime(date('Y-m-d',strtotime($pr->tglpresensi)).$shift->shift_jamaawal);
                            }                                           
                            //$tepat =  strtotime(date('Y-m-d',strtotime($pr->tglpresensi)).' '.$data->pegawai->shift->shift_jamawal);
                    }else{
                        $tepat =  strtotime(date('Y-m-d',strtotime($pr->tglpresensi)).' '.ShiftM::model()->getShift($jammasuk,$jampulang, $jamM, $jamP, 2));
                    }
                }  else {
                    return ShiftM::model()->getJam($cekJadwal,2);
                }
            }
            else
            {
                return ShiftM::model()->getJam($cekPertukaran,2);
            }
           
            $pulang = strtotime(date('Y-m-d H:i:s',strtotime($pr->tglpresensi)));
            if ($pulang > $tepat){
                $pulang = $tepat;
            }
            $menit = floor(round(abs($pulang - $tepat) / 60,2));
            $total = $total + $menit;
        endforeach;        
        $j =  floor(abs($total) / 60);                       
        $m =  floor(abs(($total / 60) - $j) * 60);
        
      //  if ($pulang > $tepat){
         //   echo  "0 Jam";
      //  }else{
            echo $j.' Jam '.$m.' Menit';
       // }
    
    }
?>