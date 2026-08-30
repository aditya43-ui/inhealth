<?php

$modMorbiditas = RDPasienMorbiditasT::model()->with('diagnosa')->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
$jumlahMorbiditas = count((array)$modMorbiditas);
$result = array();
foreach($modMorbiditas as $row){
        $result[] = $row->diagnosa->diagnosa_nama;
}
echo implode(', ',$result);
?>