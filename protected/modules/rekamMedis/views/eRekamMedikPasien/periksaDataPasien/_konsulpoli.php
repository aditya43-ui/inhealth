<?php

$modKonsulPoli = KonsulpoliT::model()->with('poliasal','politujuan')->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
$jumlah = count((array)$modKonsulPoli);
$result = array();
foreach($modKonsulPoli as $row){
        $result[] = $row->politujuan->ruangan_nama;    
}
echo implode(', ',$result);
?>