<ol>
<?php
foreach( $data as $i=>$resep){
    echo "<li>";
    echo $resep->obatalkes->jenisobatalkes->jenisobatalkes_nama." - ".$resep->obatalkes->obatalkes_nama." : ".$resep->qty_oa." ".$resep->satuankecil->satuankecil_nama;
    echo "</li>";
}
?>
</ol>
