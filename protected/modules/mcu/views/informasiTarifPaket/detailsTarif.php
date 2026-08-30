<?php
echo "<table>";
echo "<tr>
        <td>Tipe Paket</td>
        <td>:</td>
        <td>" . $modTarif->tipepaket_nama . "</td>
         </tr>";
echo "<tr>
        <td>Kelas Pelayanan</td>
        <td>:</td>
        <td>" . $modTarif->kelaspelayanan_nama . "</td>      
         </tr>";
echo "<tr>
        <td>Penjamin</td>
        <td>:</td>
        <td>" . $modTarif->penjamin_nama . "</td>      
    </tr>";
if ($jumlahTarifTindakan > 0) {
    echo '<div id="detail-tarif" class="grid-view">
                            <div class="summary">';
    echo "<table class='table table-bordered table-condensed'>";
    echo "<thead> <tr style='background-color:#F0F0FF;'>
                <td>Daftar Tindakan</td>
                <td>Ruangan</td>
                <td>Tarif Paket Pelayanan<br>(Rp)</td>
                <td>Tanggungan Asuransi<br>(Rp)</td>
                <td>Harga Iur Biaya<br>(Rp)</td>
            </tr></thead><tbody>";
    $tarifTotal = null;
    $total_tarif = 0;
    $total_subsidi = 0;
    $total_iur = 0;
    foreach ($modTarifTindakan as $tampilTarifTindakan) :
        $total_tarif += $tampilTarifTindakan['tarifpaketpel'];
        $total_subsidi += $tampilTarifTindakan['subsidiasuransi'];
        $total_iur += $tampilTarifTindakan['iurbiaya'];
        $ruangan = RuanganM::model()->findByPk($tampilTarifTindakan->ruangan_id);
        echo "<tr>
            <td>" . $tampilTarifTindakan->daftartindakan_nama . "</td>
            <td>" . (empty($ruangan) ? "-" : $ruangan->ruangan_nama) . "</td>
            <td style='text-align:right;'>" . number_format($tampilTarifTindakan['tarifpaketpel'], 0, "", ".") . "</td>    
            <td style='text-align:right;'>" . number_format($tampilTarifTindakan['subsidiasuransi'], 0, "", ".") . "</td>    
            <td style='text-align:right;'>" . number_format($tampilTarifTindakan['iurbiaya'], 0, "", ".") . "</td>    
          </tr>";
    // $tarifTotal=$tarifTotal+$tampilTarifTindakan['harga_tariftindakan'];
    endforeach;
    echo "<tr>
        <td colspan=\"5\">
     <tr>
        <td colspan=\"2\">Total</td>
        <td style='text-align:right;'>" . number_format($total_tarif, 0, "", ".") . "
        <td style='text-align:right;'>" . number_format($total_subsidi, 0, "", ".") . "
        <td style='text-align:right;'>" . number_format($total_iur, 0, "", ".") . "
    </table>";
} else {
    echo "Tarif Belum Disetting";
}
