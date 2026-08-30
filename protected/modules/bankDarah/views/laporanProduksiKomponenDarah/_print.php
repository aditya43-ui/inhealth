<?php
/**
* - digunakan sebagai Laporan Skrining IMLTD
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>
<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew',array('judulLaporan'=>$judulLaporan , 'colspan'=>16));  
//var_dump(!empty($variabel2));
if ($caraPrint != 'GRAFIK'){
    $this->renderPartial('_tablePrint', array('caraPrint'=>$caraPrint,'data'=>$model)); 
}
if ($caraPrint == 'GRAFIK'){
    echo $this->renderPartial('_grafik', array('model2'=>$model2, 'data'=>$data, 'caraPrint'=>$caraPrint), true); 
}

?>