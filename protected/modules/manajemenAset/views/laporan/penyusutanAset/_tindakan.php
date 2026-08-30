<?php
$mod = LaporansensuharianrjV::model()->findAll('pendaftaran_id = '.$id);
if (count($mod) > 0){
    echo '<ul>';
    foreach ($mod as $i=>$row){
        if (!empty($row->daftartindakan_nama)){
            echo '<li>'.$row->daftartindakan_nama.'</li>';
        }
    }
    echo '</ul>';
}
