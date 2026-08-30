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
    $dataArray["$data->jenisdiet_id"]["jml_kirim"] = number_format($data->jml_kirim);
    $dataArray["$data->jenisdiet_id"]["jml_perhari"] = number_format($data->jml_perhari,1);
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
                            echo "<tr>";
                            echo "<th width='50px'>No.</th>";
                            echo "<th>Uraian dan Jenis Diet</th>";
                            echo "<th width='150px'>Jumlah Total</th>";
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
