<!--<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-book-open"></i> Detail <b>Komponen Tarif</b>
        </div>
    </div>
    <div class="panel-body">-->
<!--kategori tindakan = jneis traif-->
<!--isset($modTarif['kategoritindakan_nama']) ? $modTarif['kategoritindakan_nama'] : "-"-->
<?php
echo "<table>";
echo "<tr>
        <td style='width: 100px;'>Jenis Tarif</td>
        <td style='width: 10px;'>:</td>
        <td>" . (isset($modTarif['jenistarif_nama']) ? $modTarif['jenistarif_nama'] : "-") . "</td>

         </tr>";
echo "<tr>
        <td>Uraian Tindakan</td>
        <td>:</td>
        <td>" . $modTarif['daftartindakan_nama'] . "</td>      

         </tr>";
echo "<tr>
        <td>Penjamin</td>
        <td>:</td>
        <td>" . $modTarif['penjamin_nama'] . "</td>      

         </tr>";

if ($jumlahTarifTindakan > 0) { //Jika Tarif Sudah Disetting Didata Masternya dan ada
    echo '<div id="detail-tarif" class="grid-view">
                            <div class="summary">';
    echo "<table class='table table-bordered'>";
    echo "<thead><tr>
                <td>Nama Komponen</td>
                <td>Tarif</td>
            </tr></thead><tbody>";
    $tarifTotal = 0;
    foreach ($modTarifTindakan as $tampilTarifTindakan) :
        echo "<tr>
            <td>" . $tampilTarifTindakan->komponentarif['komponentarif_nama'] . "</td>
            <td style = 'text-align:right;'>Rp" . number_format($tampilTarifTindakan['harga_tariftindakan'], 0, "", ".") . "</td>    
          </tr>";
        $tarifTotal = $tarifTotal + $tampilTarifTindakan['harga_tariftindakan'];
    endforeach;
    echo "<tr><td colspan='2' style='padding: 5px 0 0;'><tr>
        <td>Total</td>
        <td style = 'text-align:right;'>Rp" . number_format($tarifTotal, 0, "", ".") . "
    </table>";
} else {
    echo "Tarif Belum Disetting";
}
?>
<!--</div>
</div>-->