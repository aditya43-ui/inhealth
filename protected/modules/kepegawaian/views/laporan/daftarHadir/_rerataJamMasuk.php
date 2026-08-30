<?php
//    $modStatuspresensi = PresensiT::model()->findByAttributes(array('karyawan_id'=>$karyawan_id, 'statusscan_id'=>$statusscan_id, 'date(tglpresensi)'=>'2012-10-09 08:23:09'));       
    $format = new MyFormatter();
    $cr = new CDbCriteria();                            
    $cr->addBetweenCondition('tglpresensi', $format->formatDateTimeForDb($tgl_awal), $format->formatDateTimeForDb($tgl_akhir));    
    $cr->compare('pegawai_id', $pegawai_id);
    $cr->addCondition('statusscan_id=:p1');
    $cr->params[':p1'] = $statusscan_id;
    $pr = PresensiT::model()->findAll($cr);
   
    if (empty($pr)){echo "-";
    }else{         
        $total = 0;
        $bagi = count((array)$pr);
        foreach ($pr as $pr):
            $tepat = strtotime(date('Y-m-d',strtotime($pr->tglpresensi))." 00:00:00");
            $masuk = strtotime(date('Y-m-d H:i:s',strtotime($pr->tglpresensi)));
            
            $menit = round(abs($masuk - $tepat) / 60,2);            
            $total = $total + $menit;
        endforeach;        
        $j =  round(abs($total) / 60,2);                       
        $m =  round(abs(($total / 60) - floor($j)) * 60,2);
        $d =  round((abs(($total / 60) - $j) * 60) * 60,2);
        
        $h = floor($j/$bagi);
        $m = floor($m/$bagi);
        $s = floor($d/$bagi);
     
        echo (($h<10)?'0':'').$h.':'.(($m<10)?'0':'').$m.':'.(($s<10)?'0':'').$s;
       
    
    }
?>