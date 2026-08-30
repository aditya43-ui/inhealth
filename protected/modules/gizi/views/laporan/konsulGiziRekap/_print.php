<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
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
			<div class="judulcontent"> <?php echo $judulLaporan   ?> <br></div>
                        <br>
                <?php  $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
$sort = true;
echo "
        <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing: 0;
                padding: 0;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
                
            }
            
        </style>";

if (isset($caraPrint)) {
    $datas = $model->searchTable();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $datas = $model->searchTable();
    $template = "{summary}\n{items}\n{pager}";
}
?>
<?php
$dataArray = array();
// echo count((array)$models);
// exit;
// foreach($models AS $row => $data){ 
//     $dataArray["$data->ruanganasal_id"]["ruanganasal_id"] = $data->ruanganasal_id;
//     $dataArray["$data->ruanganasal_id"]["ruanganasal_nama"] = $data->ruanganasal_nama;
//     $dataArray["$data->ruanganasal_id"]["daftartindakan_id"] = $data->daftartindakan_id;
//     $dataArray["$data->ruanganasal_id"]["daftartindakan_nama"] = $data->daftartindakan_nama;
//     $dataArray["$data->ruanganasal_id"]["jmlkonsulgizi"] = $data->jmlkonsulgizi;
// }
?>
<table width="100%" style='margin-left:auto; margin-right:auto;' class='table table-striped table-condensed'>
    <thead>
        <tr>
            <th>Ruang</th>
            <th>Jenis Konsultasi Gizi</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $jumlah = 0;
        foreach ($models as $i => $datas) {
            echo "<tr>";
            // if ($models[$i]['ruanganasal_id'] == $models[$i-1]['ruanganasal_id']){
            //     echo "<td></td>";
            // }else{
            echo "<td>";
            echo $datas['ruanganasal_nama'];
            echo "</td>";
            //  }
            echo "<td>";
            echo $datas['daftartindakan_nama'];
            echo "</td>";
            echo "<td style='text-align:right'>";
            echo $datas['jmlkonsulgizi'];
            echo "</td>";
            echo "</tr>";
            $jumlah += $datas['jmlkonsulgizi'];
        }
        $totJumlah = $jumlah;
        echo "<tr>";
        echo '<td colspan=2 style="text-align:right"><b>JUMLAH</b></td>';
        echo '<td style="text-align:right"><b>' . $totJumlah . '</b></td>';
        echo "</tr>";
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
    <div class="judulcontent"> <?php echo $judulLaporan   ?> <br></div>
     <br>
<?php $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
$sort = true;
echo "
        <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing: 0;
                padding: 0;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
                
            }
            
        </style>";

if (isset($caraPrint)) {
    $datas = $model->searchTable();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $datas = $model->searchTable();
    $template = "{summary}\n{items}\n{pager}";
}
?>
<?php
$dataArray = array();
// echo count((array)$models);
// exit;
// foreach($models AS $row => $data){ 
//     $dataArray["$data->ruanganasal_id"]["ruanganasal_id"] = $data->ruanganasal_id;
//     $dataArray["$data->ruanganasal_id"]["ruanganasal_nama"] = $data->ruanganasal_nama;
//     $dataArray["$data->ruanganasal_id"]["daftartindakan_id"] = $data->daftartindakan_id;
//     $dataArray["$data->ruanganasal_id"]["daftartindakan_nama"] = $data->daftartindakan_nama;
//     $dataArray["$data->ruanganasal_id"]["jmlkonsulgizi"] = $data->jmlkonsulgizi;
// }
?>
<table width="100%" style='margin-left:auto; margin-right:auto;' class='table table-striped table-condensed'>
    <thead>
        <tr>
            <th>Ruang</th>
            <th>Jenis Konsultasi Gizi</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $jumlah = 0;
        foreach ($models as $i => $datas) {
            echo "<tr>";
            // if ($models[$i]['ruanganasal_id'] == $models[$i-1]['ruanganasal_id']){
            //     echo "<td></td>";
            // }else{
            echo "<td>";
            echo $datas['ruanganasal_nama'];
            echo "</td>";
            //  }
            echo "<td>";
            echo $datas['daftartindakan_nama'];
            echo "</td>";
            echo "<td style='text-align:right'>";
            echo $datas['jmlkonsulgizi'];
            echo "</td>";
            echo "</tr>";
            $jumlah += $datas['jmlkonsulgizi'];
        }
        $totJumlah = $jumlah;
        echo "<tr>";
        echo '<td colspan=2 style="text-align:right"><b>JUMLAH</b></td>';
        echo '<td style="text-align:right"><b>' . $totJumlah . '</b></td>';
        echo "</tr>";
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
			<div class="judulcontent"> <?php echo $judulLaporan   ?> <br></div>
                        <br>
                        <?php  $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
$sort = true;
echo "
        <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing: 0;
                padding: 0;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
                
            }
            
        </style>";

if (isset($caraPrint)) {
    $datas = $model->searchTable();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $datas = $model->searchTable();
    $template = "{summary}\n{items}\n{pager}";
}
?>
<?php
$dataArray = array();
// echo count((array)$models);
// exit;
// foreach($models AS $row => $data){ 
//     $dataArray["$data->ruanganasal_id"]["ruanganasal_id"] = $data->ruanganasal_id;
//     $dataArray["$data->ruanganasal_id"]["ruanganasal_nama"] = $data->ruanganasal_nama;
//     $dataArray["$data->ruanganasal_id"]["daftartindakan_id"] = $data->daftartindakan_id;
//     $dataArray["$data->ruanganasal_id"]["daftartindakan_nama"] = $data->daftartindakan_nama;
//     $dataArray["$data->ruanganasal_id"]["jmlkonsulgizi"] = $data->jmlkonsulgizi;
// }
?>
<table width="100%" style='margin-left:auto; margin-right:auto;' class='table table-striped table-condensed'>
    <thead>
        <tr>
            <th>Ruang</th>
            <th>Jenis Konsultasi Gizi</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $jumlah = 0;
        foreach ($models as $i => $datas) {
            echo "<tr>";
            // if ($models[$i]['ruanganasal_id'] == $models[$i-1]['ruanganasal_id']){
            //     echo "<td></td>";
            // }else{
            echo "<td>";
            echo $datas['ruanganasal_nama'];
            echo "</td>";
            //  }
            echo "<td>";
            echo $datas['daftartindakan_nama'];
            echo "</td>";
            echo "<td style='text-align:right'>";
            echo $datas['jmlkonsulgizi'];
            echo "</td>";
            echo "</tr>";
            $jumlah += $datas['jmlkonsulgizi'];
        }
        $totJumlah = $jumlah;
        echo "<tr>";
        echo '<td colspan=2 style="text-align:right"><b>JUMLAH</b></td>';
        echo '<td style="text-align:right"><b>' . $totJumlah . '</b></td>';
        echo "</tr>";
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