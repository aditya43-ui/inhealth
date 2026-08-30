<?php
    $sql = "SELECT * FROM presensi_t WHERE pegawai_id = '".$pegawai_id ."' AND statusscan_id = '". $statusscan_id ."' AND DATE(tglpresensi) = '". $datepresensi ."'";
    $records = YII::app()->db->createCommand($sql)->queryRow();
    if(!empty($records['tglpresensi']))
    {
        $jam = date('H:m:s', strtotime($records['tglpresensi']));
        echo $jam;
    } else {
        echo "-";
    }
?>