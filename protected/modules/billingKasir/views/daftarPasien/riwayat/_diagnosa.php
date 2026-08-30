<div class="anamnesis_judul">DIAGNOSA</div>
<table class="anamnesa_content">
    <tr>
        <td width="150">Diagnosa Utama</td>
        <td width="10">:</td>
        <td><?php echo empty($morbid->diagnosa) ? "-" : ($morbid->diagnosa->diagnosa_kode." - ".$morbid->diagnosa->diagnosa_nama) ?></td>
    </tr>
    <tr>
        <td>Diagnosa Tambahan</td>
        <td>:</td>
        <td><?php
        if (count($morbidTambahan) == 0) {
            "-";
        } else {
            echo "<ul>";
            foreach ($morbidTambahan as $morbid) {
                echo "<li>";
                echo empty($morbid->diagnosa) ? "-" : ($morbid->diagnosa->diagnosa_kode." - ".$morbid->diagnosa->diagnosa_nama);
                echo "</li>";
            } 
            echo "</ul>";
        }
        ?></td>
    </tr>
</table>
<hr />