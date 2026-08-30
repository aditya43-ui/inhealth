<?php
$modJadwalTergroup = array();
foreach ($modJadwal as $counter => $jadwal){
    $modJadwalTergroup[$jadwal['ruangan_nama']][$jadwal['jadwaldokter_hari']][] = $jadwal;
}
foreach ($modJadwalTergroup as $counter2=>$jadwal2) {
    echo "<tr><td>$counter2</td>";
    foreach (CustomFunction::getNamaHari() as $value) {
        echo "<td><ul>";
        if(isset($jadwal2[$value]))
        {        
        foreach ($jadwal2[$value] as $pegawai) {
            if (!empty($pegawai['nama_pegawai'])){
                echo "<li>$pegawai[nama_pegawai]<a href='' class='pilihDokter' valueRuangan='$pegawai[ruangan_id]' valuePegawai='$pegawai[pegawai_id]'><i class=\"icon-check\"></i></a></li>";
            }
        }
        }
        echo "</ul></td>";
        
    }
    echo "</tr>";
}
?>
