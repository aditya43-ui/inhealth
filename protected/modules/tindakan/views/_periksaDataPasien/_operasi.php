<?php

$modOperasi = RJRencanaoperasiT::model()->with('operasi')->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
$jumlah = count((array)$modOperasi);
$result = array();
foreach($modOperasi as $row){
    
        $result[] = $row->operasi->operasi_nama;
    
}
echo implode(', ',$result);
?>