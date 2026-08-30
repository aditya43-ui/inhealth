<style type="text/css">
    .text-center{
        text-align: center !important; 
    }
</style>
<?php 
$dataArray = array();
$header = true;
$format = new MyFormatter();
$mergeTanggal = array();
$dataHari = array();
foreach($models AS $row => $data){ 
    $hr = date('d', strtotime($data->tglpesanmenu));
    $dataArray[$data->menudiet_id][$hr][] = array('tglpesanmenu'=>$hr, 'menudiet_id'=>$data->menudiet_id,'menudiet_nama'=>$data->menudiet_nama,'jumlah'=>$data->jml_pesan_porsi);
    $dataHari[$hr] = $hr;
} 

$jumlahPerMenu = array();
$jumlahPerHari = array();
?>
<table class="table table-striped table-condensed">
    <thead>
        <tr>
            <th rowspan=2>No</th>
            <th rowspan=2>Jenis PMT</th>
            <th colspan="<?php echo count((array)$dataHari); ?>">Tanggal</th>
            <th rowspan=2>Total</th>
        </tr>
        <tr>
            <?php 
            if(count((array)$dataArray) > 0){
                $tgl = "";
                foreach ($dataHari as $i => $dataH){
                    echo '<th>'.$dataH.'</th>';
                }
            }else{
                 echo '<th></th>';
            }
            ?>
        </tr>
    </thead>
   
    <tbody>
        <?php 
        $html = "";
            if(count((array)$dataArray) > 0){
                $no = 1;
                 $totalAll = 0;
                 
                foreach ($dataArray as $i =>$dataM){
                    $menu = "";
                    $jml = 0;
                    foreach ($dataHari as $l => $daa){
                        if(isset($dataM[$l]) && count((array)$dataM[$l]) > 0){
                            foreach ($dataM[$l] as $dataPorsi){
                                $menu = $dataPorsi['menudiet_nama'];
                            }
                        }
                    }

                    $html .= "<tr>"
                                  . "<td>".$no++."</td>"
                                  . "<td>".$menu."</td>";
                     $jmlAll = 0;

                    foreach ($dataHari as $l => $daa){
                        $jmlpor = 0;
                        if(isset($dataM[$l]) && count((array)$dataM[$l]) > 0){
                            foreach ($dataM[$l] as $dataPorsi){
                                $jmlpor += $dataPorsi['jumlah'];
                            }
                        }
                        $jmlAll += $jmlpor;
                            $html .= "<td>".$jmlpor."</td>";

                    }
                         $totalAll += $jmlAll;
                      $html .= "<td>".$jmlAll."</td>";
                    $html .= "</tr>";
                }
            }else{
               echo "<tr><td colspan='4'>Data tidak ditemukan.</td></tr>"; 
            }
        
            echo $html;
                
            ?>
    </tbody>
    <?php  if(count((array)$dataArray) > 0){ ?>
    <tfoot>
        <tr>
            <td colspan="2"><b>JUMLAH</b></td>
            <?php
            $arrayHitung = array();
            foreach ($dataHari as $l => $daa){
                $jmlpor = 0;
                foreach ($dataArray as $i =>$dataM){
                    if(isset($dataM[$l]) && count((array)$dataM[$l]) > 0){
                        foreach ($dataM[$l] as $dataPorsi){
                            $jmlpor += $dataPorsi['jumlah'];
                        }
                    }
                }
                $arrayHitung[$l] = $jmlpor; 
            }
                
                if(count((array)$arrayHitung) >0){
                    foreach ($arrayHitung as $dataHitung){
                        echo "<td><b>".$dataHitung."</b></td>";
                    }
                }
            ?>
            <td><b><?php echo $totalAll; ?></b></td>
        </tr>
    </tfoot>
    <?php } ?>
</table>