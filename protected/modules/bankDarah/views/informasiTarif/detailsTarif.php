<?php
echo "<table>";
echo "<tr>
        <td>Kategori Pemeriksaan</td>
        <td>".$modTarif ['kategoritindakan_nama']."</td>

         </tr>";
echo "<tr>
        <td>Nama Pemeriksaan</td>
        <td>".$modTarif ['daftartindakan_nama']."</td>      

         </tr>";

if($jumlahTarifTindakan>0){//Jika Tarif Sudah Disetting Didata Masternya dan ada
echo "<table>";
foreach($modTarifTindakan AS $tampilTarifTindakan):
    echo "<tr>
            <td>".$tampilTarifTindakan->komponentarif['komponentarif_nama']."</td>
            <td>".$tampilTarifTindakan['harga_tariftindakan']."</td>    
          </tr>"; 
$tarifTotal=$tarifTotal+$tampilTarifTindakan['harga_tariftindakan'];
endforeach;
echo "<tr>
        <td colspan=\"2\"><hr>
     <tr>
        <td>Total</td>
        <td>".$tarifTotal."
    </table>";
}else{
    echo "Tarif Belum Disetting";
}
?>