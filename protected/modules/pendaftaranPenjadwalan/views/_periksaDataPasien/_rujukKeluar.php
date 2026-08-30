<?php

$modRujuk = PasiendirujukkeluarT::model()->with('rujukankeluar')->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
$jumlah = count((array)$modRujuk);
$result = array();
foreach($modRujuk as $row){
    
        $result[] = $row->rujukankeluar->rumahsakitrujukan.'-'.$row->kepadayth;
    }
    
echo implode(', ',$result);
?>