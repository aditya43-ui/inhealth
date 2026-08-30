<?php 
$dataArray = array();
$header = true;
$format = new MyFormatter();
$mergeTanggal = array();

foreach($models AS $row => $data){ 
    $dataArray["$data->jenisdiet_id"]["jenisdiet_id"] = $data->jenisdiet_id;
    $dataArray["$data->jenisdiet_id"]["jenisdiet_nama"] = $data->jenisdiet_nama;
    $dataArray["$data->jenisdiet_id"]["$data->jeniswaktu_id"]["tglkirimmenu"] = date('d-m-Y',strtotime($data->tglkirimmenu));
    $dataArray["$data->jenisdiet_id"]["$data->jeniswaktu_id"]["jml_kirim"] =  $data->jml_kirim;
    $dataArray["$data->jenisdiet_id"]["$data->jeniswaktu_id"]["jeniswaktu_id"] = $data->jeniswaktu_id;
    $dataArray["$data->jenisdiet_id"]["$data->jeniswaktu_id"]["jeniswaktu_nama"] = $data->jeniswaktu_nama;
} 
?>
<table class="table table-striped table-condensed">
    <thead>
    <?php 
        $jmlKolom = 0;
        $jenisWaktus = array();
        $tglKirims = array();
        $jeniswaktuM = JenisWaktuM::model()->findAll('jeniswaktu_aktif = true');
        echo "<tr>";
        echo "<th rowspan=2>No.</th>";
        echo "<th rowspan=2>Uraian dan Jenis Diet</th>";
        echo "</tr>";
        echo "<tr>";
            foreach ($jeniswaktuM AS $i => $datas){
                echo "<th>";
                echo $datas->jeniswaktu_nama;
                echo "</th>";
            }
        echo "</tr>";
    ?>
    </thead>
    <tbody>
        <?php

        $no = 1;
        $jml = array();
        
        foreach ($dataArray AS $i => $datas){
            echo "<tr>";
            echo "<td>".$no."</td>";
            echo "<td>";
            echo $datas['jenisdiet_nama'];
            echo "</td>";
            
            foreach ($jeniswaktuM AS $h => $dataJnswaktu){
                if(isset($datas[$dataJnswaktu->jeniswaktu_id]) && is_array($datas[$dataJnswaktu->jeniswaktu_id])){
                    echo "<td>";
                    echo $datas[$dataJnswaktu->jeniswaktu_id]['jml_kirim'];
                    echo "</td>";
                }else{
                     echo "<td>";
                    echo 0;
                    echo "</td>";
                } 
            }
            echo "</tr>";
            $no ++;
        }
        
        ?>
        
    </tbody>
    
</table>