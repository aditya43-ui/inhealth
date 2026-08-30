<?php
//    $modStatuspresensi = PresensiT::model()->findByAttributes(array('karyawan_id'=>$karyawan_id, 'statusscan_id'=>$statusscan_id, 'date(tglpresensi)'=>'2012-10-09 08:23:09'));
    $modStatuspresensi = PresensiT::model()->find("pegawai_id=$pegawai_id AND DATE(tglpresensi)='$datepresensi' AND statuskehadiran_id is NOT NULL");
    $modStatuskehadiran = StatuskehadiranM::model()->findByPK($modStatuspresensi->statuskehadiran_id);
    if (!empty($modStatuskehadiran))
    {
        echo $modStatuskehadiran->statuskehadiran_nama;
    } else {
        echo "-";
    }
?>