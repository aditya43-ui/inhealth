<?php 
$dataArray = array();
$header = true;
$format = new MyFormatter();
$mergeTanggal = array();
foreach($models AS $row => $data){ 
    $dataArray["$data->jenisdiet_id"]["jenisdiet_id"] = $data->jenisdiet_id;
    $dataArray["$data->jenisdiet_id"]["jenisdiet_nama"] = $data->jenisdiet_nama;
    $dataArray["$data->jenisdiet_id"]["jml_kirim"] = number_format($data->jml_kirim);
    $dataArray["$data->jenisdiet_id"]["jml_perhari"] = number_format($data->jml_perhari,1);
} 

?>
<table class="table table-striped table-condensed">
    <thead>
    <?php 
        echo "<tr>";
        echo "<th>No.</th>";
        echo "<th>Uraian dan Jenis Diet</th>";
        echo "<th>Jumlah Total</th>";
//        echo "<th>Rata-rata Per-hari</th>";
        
    ?>
    </thead>
    <tbody>
        <?php

        $no = 1;
        $jml = array();
        foreach ($dataArray AS $i => $data){
            echo "<tr>";
            echo "<td>".$no."</td>";
            echo "<td>".$data['jenisdiet_nama']."</td>";
            echo "<td>".$data['jml_kirim']."</td>";
//            echo "<td>".$data['jml_perhari']."</td>";
            echo "</tr>";
            $no ++;
        }
        
        ?>
        
    </tbody>
    
</table>