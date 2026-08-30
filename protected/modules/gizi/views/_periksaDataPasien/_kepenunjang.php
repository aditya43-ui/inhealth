<?php
$result = "";
$modMasukPenunjang = GZPasienMasukPenunjangT::model()->with('ruangan')->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
$jumlah = count((array)$modMasukPenunjang);
foreach($modMasukPenunjang as $row){
        $result .= '<li>'.$row->ruangan->ruangan_nama.'</li>';
}
echo $result;
?>