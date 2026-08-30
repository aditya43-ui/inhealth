<?php

$modOperasi = RencanaoperasiT::model()->with('operasi')->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
$jumlah = count($modOperasi);
$result = array();
foreach($modOperasi as $row){
    
        $result[] = $row->operasi->operasi_nama;
    
}
echo implode(', ',$result);
?>