<ol>
<?php
foreach( $data as $i=>$resep){
    echo "<li>";
    echo $resep->obatalkes->jenisobatalkes->jenisobatalkes_nama." - ".$resep->obatalkes->obatalkes_nama." : ".$resep->qty_reseptur." ".$resep->signa_reseptur;
    echo "</li>";
}
?>
</ol>
