<?php 
if (isset($pendaftaran_id)){
    $modPasienMasuk = PasienmasukpenunjangT::model()->findAll('pendaftaran_id =:pendaftaran', array(':pendaftaran'=>$pendaftaran_id));
    if (count((array)$modPasienMasuk) > 0){
        echo '<ul>';
        foreach ($modPasienMasuk as $key => $value) {
            $tanggal = date('d M Y H:i:s', strtotime($value->tglmasukpenunjang));
            echo "<li>{$tanggal} - {$value->ruangan->ruangan_nama}</li>";
        }
        echo '</ul>';
    }
}
?>