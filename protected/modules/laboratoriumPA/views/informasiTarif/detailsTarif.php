<?php
echo "<table>";
echo "<tr>
        <td>Kategori Pemeriksaan</td>
        <td>:</td>
        <td>".$modTarif ['kategoritindakan_nama']."</td>

         </tr>";
echo "<tr>
        <td>Nama Pemeriksaan</td>
        <td>:</td>
        <td>".$modTarif ['daftartindakan_nama']."</td>      

         </tr>";
echo "<tr>
        <td>Jenis Tarif</td>
        <td>:</td>
        <td>".$modTarif['jenistarif_nama']."</td>      

         </tr>";

if($jumlahTarifTindakan>0){//Jika Tarif Sudah Disetting Didata Masternya dan ada
 echo '<div id="detail-tarif" class="grid-view">
                            <div class="summary">';
echo "<table class='table table-bordered table-condensed'>";
    echo "<thead> <tr style='background-color:#F0F0FF;'>
                <td>Nama Komponen</td>
                <td>Tarif</td>
            </tr></thead><tbody>";
$tarifTotal = null;
foreach($modTarifTindakan AS $tampilTarifTindakan):
    echo "<tr>
            <td>".$tampilTarifTindakan->komponentarif['komponentarif_nama']."</td>
            <td style='text-align:right;'>Rp".number_format($tampilTarifTindakan['harga_tariftindakan'],0,'','.')."</td>    
          </tr>"; 

$tarifTotal=$tarifTotal+$tampilTarifTindakan['harga_tariftindakan'];
endforeach;
echo "<tr>
        <td colspan=\"2\">
     <tr>
        <td>Total</td>
        <td style='text-align:right;'>Rp".number_format($tarifTotal,0,'','.')."
    </table>";
}else{
    echo "Tarif Belum Disetting";
}
?>