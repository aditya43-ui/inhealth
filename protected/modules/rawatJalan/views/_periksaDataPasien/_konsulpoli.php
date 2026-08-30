<?php

$modKonsulPoli = RJKonsulPoliT::model()->with('poliasal','politujuan')->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
$jumlah = count((array)$modKonsulPoli);
$result = array();
foreach($modKonsulPoli as $row){
        if (empty($row->ruangan_id)) {
                continue;
        }
        $result[] = $row->politujuan->ruangan_nama;    
}
echo implode(', ',$result);
?>