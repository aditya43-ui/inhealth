<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$jenis.'"');
header('Cache-Control: max-age=0');  

echo "<table border = 1>";
echo "<thead><tr><th>Baris</th><th>Keterangan</th></tr></thead>";
echo "<tbody>";

foreach($model as $key => $val){    
    echo "<tr>";
    echo "<th colspan=1> Baris ".$key."</th>";    
    echo "<td></td>";
    echo "</tr>";
    if (isset($val['list_obat'])){
        echo "<tr>";
        echo "<td></td>";
        echo "<td>".$val['list_obat']."</td>";
        echo "</tr>";
    }
}
echo "</tbody>";
echo "</table>";