<?php
//    $modStatuspresensi = PresensiT::model()->findByAttributes(array('karyawan_id'=>$karyawan_id, 'statusscan_id'=>$statusscan_id, 'date(tglpresensi)'=>'2012-10-09 08:23:09'));
    $modStatuspresensi = PresensiT::model()->find("pegawai_id=$pegawai_id AND statusscan_id=$statusscan_id AND DATE(tglpresensi)='$datepresensi'");
    $format = new MyFormatter();
    if (!empty($modStatuspresensi))
    {
        
        $tglpresensi = $format->formatDateTimeForDb($modStatuspresensi->tglpresensi);
//        echo $tglpresensi;
        echo date('H:i:s', strtotime($tglpresensi));
    } else {
        echo "-";
    }
?>