<style>
    table .table td{
        border: 1px #000 solid;
    }
    .tablepadding{
        width: 100%;
    }
    .tablepadding td, .tablepadding th{
        border: 1px #000 solid;
        padding: 5px;
    }
</style>
<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}

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

if ($caraPrint != 'PDF'){
?>
<table width="100%">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                    <br>
                        <div class="judulcontent">
                            <center>
                                <h3><?php echo $judulLaporan; ?></h3>
                                <h4><?php echo $periodeLaporan; ?></h4>
                            </center>

                        </div>
                    <br>
                    <table class="tablepadding">
                        <thead>
                        <?php 
                            $jmlKolom = 0;
                            $jenisWaktus = array();
                            $tglKirims = array();
                            $jeniswaktuM = JenisWaktuM::model()->findAll('jeniswaktu_aktif = true');
                            echo "<tr>";
                            echo "<th rowspan=2 width='50px'>No.</th>";
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
		        </div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>

<?php
}else{
?>
    <div class="header">
        <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
    </div>
    <div class="content">
        <br>
            <div class="judulcontent">
                <center>
                    <h3><?php echo $judulLaporan; ?></h3>
                    <h4><?php echo $periodeLaporan; ?></h4>
                </center>
            </div>
        <br>
        <table class="tablepadding">
            <thead>
            <?php 
                $jmlKolom = 0;
                $jenisWaktus = array();
                $tglKirims = array();
                $jeniswaktuM = JenisWaktuM::model()->findAll('jeniswaktu_aktif = true');
                echo "<tr>";
                echo "<th rowspan=2 width='50px'>No.</th>";
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
    </div>
<?php 
}
?>
<div class="">
</div>
<div class="footer">
    <?php   if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>   
