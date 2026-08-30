<ol>
<?php
//Yang dulu menggunakan relation di modelnya tapi tidak muncul datanya
//echo "</pre>";
//foreach( $data->obatalkes as $i=>$resep){
//    echo "<li>";
//    echo $resep->jenisobatalkes->jenisobatalkes_nama." - ".$resep->obatalkes_nama;
//    echo "</li>";
//}
?>
<?php
foreach( $data as $i=>$resep){
    echo "<li>";
    echo $resep->obatalkes->jenisobatalkes->jenisobatalkes_nama." - ".$resep->obatalkes->obatalkes_nama." : ".$resep->qty_oa." ".$resep->satuankecil->satuankecil_nama;
    echo "</li>";
}
?>
</ol>
