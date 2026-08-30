<?php
$modDaftarTindakan = TindakanruanganM::model()->findAll('ruangan_id=' . $ruangan_id . '');
$modTarifTindakan = TariftindakanM::model()->findAllByAttributes(array('daftartindakan_id' => $modDaftarTindakan[0]->daftartindakan_id));
$daftarTindakan = array();
if (count((array)$modDaftarTindakan) > 0) {
    //echo "<ul>"; 
    foreach ($modDaftarTindakan as $i => $tindakan) {
        $daftarTindakan[$tindakan->daftartindakan->kategoritindakan->kategoritindakan_nama][$tindakan->daftartindakan->daftartindakan_nama] = $tindakan->daftartindakan->daftartindakan_nama;
        //$daftarTindakan['kategoritindakan_id']['daftartindakan_nama'] = $tindakan->daftartindakan->daftartindakan_nama;
        //echo "<li>".$tindakan->daftartindakan->daftartindakan_nama.'</li>';
    }
    //echo "</ul>";
} else {
    echo Yii::t('zii', 'Not set');
}
if (count((array)$daftarTindakan) > 0) {
    foreach ($daftarTindakan as $tes => $value) {
        echo "<ul>";
        echo "<li><b>" . $tes . "</b><br><ul>";
        foreach ($value as $i => $daftar) {
            echo "<li> - " . $daftar . "</li>";
        }
        echo "</ul></li></ul>";
    }
    //var_dump($daftarTindakan);
} else {
    echo Yii::t('zii', 'Not set');
}
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Daftar Tarif</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table class="table table-responsive table-bordered datatable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kelas Pelayanan</th>
                    <th>Nominal Tarif</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($modTarifTindakan as $key => $tarif) {
                    echo "<tr>";
                    echo "<td>" . ($key + 1) . "</td>";
                    echo "<td>" . $tarif->kelaspelayanan->kelaspelayanan_nama . "</td>";
                    echo "<td>" . number_format($tarif->harga_tariftindakan, 0, "", ".") . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>