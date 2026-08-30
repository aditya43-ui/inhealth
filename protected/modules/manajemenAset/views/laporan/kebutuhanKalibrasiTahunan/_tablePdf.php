<?php

$data = $model->search();
$data->pagination = false;

$mpdf->WriteHTML( "
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
            border-spacing:0px;
            padding:0px;
        }

        .table tbody tr:hover td, .table tbody tr:hover th {
            background-color: none;
        }
    </style>");
    $itemCssClass = 'table border';
?>

<?php

$mpdf->WriteHTML("<table class='".$itemCssClass."'>");
$mpdf->WriteHTML("<tr>
            <th>No</th>
            <th>Jenis Peralatan</th>
            <th>Tahun Perolehan</th>
            <th>Sumber Dana</th>
            <th>Jumlah yang Bisa Dikalibrasi</th>
        </tr>");
$a = 0;
foreach($data->getData() as $det){
    $mpdf->WriteHTML("<tr>
        <td>".($a+1)."</td>
        <td>".$det->barang_nama."</td>
        <td>".$det->tahun_perolehan."</td>
        <td>".$det->sumberdana."</td>
        <td align='right'>".$det->jumlah."</td>
    </tr>");  
    $a++;
}
 $mpdf->WriteHTML("<tr>
        <td colspan='4' align='right'><b>Total Keseluruhan</b></td>        
        <td align='right'>".$model->getTotal('jumlah')."</td>
    </tr>");  
    $a++;
$mpdf->WriteHTML("</table>");
?>