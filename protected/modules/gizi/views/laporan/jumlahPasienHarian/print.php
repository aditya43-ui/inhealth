<style>
    table .table td{
        border: 1px #000 solid;
    }
</style>
<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$data['judulLaporan'].'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF'){
    
    
?>

 <table style="width: 100%; border: none;">
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
			<div class="judulcontent"></div>
                        <br>
                <?php  $dataArray = array();
$header = true;
$format = new MyFormatter();
$mergeTanggal = array();
foreach($models AS $row => $data){ 
    $dataArray["$data->jenisdiet_id"]["jenisdiet_id"] = $data->jenisdiet_id;
    $dataArray["$data->jenisdiet_id"]["jenisdiet_nama"] = $data->jenisdiet_nama;
    $dataArray["$data->jenisdiet_id"]["$data->jeniswaktu_id"]["tglkirimmenu"] = date('d-m-Y',strtotime($data->tglkirimmenu));
    $dataArray["$data->jenisdiet_id"]["$data->jeniswaktu_id"]["jml_kirim"] =  number_format($data->jml_kirim);
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
<div class="">
</div>
<div class="footer">
    <?php   if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>   

<?php
}
if ($caraPrint == 'PDF'){
?>
<div class="header">
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
</div>
<div class="content">
     <br>
    <div class="judulcontent"></div>
     <br>
<?php $dataArray = array();
$header = true;
$format = new MyFormatter();
$mergeTanggal = array();
foreach($models AS $row => $data){ 
    $dataArray["$data->jenisdiet_id"]["jenisdiet_id"] = $data->jenisdiet_id;
    $dataArray["$data->jenisdiet_id"]["jenisdiet_nama"] = $data->jenisdiet_nama;
    $dataArray["$data->jenisdiet_id"]["$data->jeniswaktu_id"]["tglkirimmenu"] = date('d-m-Y',strtotime($data->tglkirimmenu));
    $dataArray["$data->jenisdiet_id"]["$data->jeniswaktu_id"]["jml_kirim"] =  number_format($data->jml_kirim);
    $dataArray["$data->jenisdiet_id"]["$data->jeniswaktu_id"]["jeniswaktu_id"] = $data->jeniswaktu_id;
    $dataArray["$data->jenisdiet_id"]["$data->jeniswaktu_id"]["jeniswaktu_nama"] = $data->jeniswaktu_nama;
} 
?>
<table class="table table-striped table-condensed">
    <thead>
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
</div>

<?php
}
if ($caraPrint == 'GRAFIK'){
 ?>
<table style="width: 100%; border: none;">
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
			<div class="judulcontent"></div>
                        <br>
                        <?php $dataArray = array();
$header = true;
$format = new MyFormatter();
$mergeTanggal = array();
foreach($models AS $row => $data){ 
    $dataArray["$data->jenisdiet_id"]["jenisdiet_id"] = $data->jenisdiet_id;
    $dataArray["$data->jenisdiet_id"]["jenisdiet_nama"] = $data->jenisdiet_nama;
    $dataArray["$data->jenisdiet_id"]["$data->jeniswaktu_id"]["tglkirimmenu"] = date('d-m-Y',strtotime($data->tglkirimmenu));
    $dataArray["$data->jenisdiet_id"]["$data->jeniswaktu_id"]["jml_kirim"] =  number_format($data->jml_kirim);
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
        echo "<tr>";
        echo "<th rowspan=2>No.</th>";
        echo "<th rowspan=2>Uraian dan Jenis Diet</th>";
        foreach ($dataArray AS $i => $datas){
            foreach($datas AS $j => $data){                
                if(is_array($data)){
                    $tglKirims[$jmlKolom] = $data['tglkirimmenu'];
//                    if($tglKirims[$jmlKolom-1] == $tglKirims[$jmlKolom]){
//                        echo "<th>";
//                        echo CustomFunction::getNamaHari($data['tglkirimmenu']);
//                        echo "</th>";
//                    }else{
                        echo "<th>";
//                        echo CustomFunction::getNamaHari($data['tglkirimmenu'])." ".$data['tglkirimmenu'];
						  echo date("j F Y", strtotime($data['tglkirimmenu']));
						echo "</th>";
//                    }
                    $jmlKolom ++;
                }
            }
        }
        echo "</tr>";
        $jmlKolom = 0;
        echo "<tr>";
        foreach ($dataArray AS $i => $datas){
            foreach($datas AS $j => $data){
                if(is_array($data)){
                    echo "<th>";
                    echo $data['jeniswaktu_nama'];
                    echo "</th>";
                    $jenisWaktus[$jmlKolom] = $data['jeniswaktu_id'];
                    $jmlKolom ++;
                }
            }
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
            //cari data jml dan masukan ke array $jml[]
            
            for($x = 0;$x < $jmlKolom;$x++){
                $jml[$x] = 0;
                foreach($datas AS $j => $data){
                    if(is_array($data)){                        
                        if($data['jeniswaktu_id'] == $jenisWaktus[$x] && $data['tglkirimmenu'] == $tglKirims[$x]){
                            $jml[$x] = $data['jml_kirim'];
                        }
                    }
                }
                
            }
            //tampilkan array $jml[]
            for($x = 0;$x < $jmlKolom;$x++){
                echo "<td>";
                echo $jml[$x];
                echo "</td>";
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
<div class="">
</div>
<div class="footer">
    <?php   if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>
  
<?php
}
?>