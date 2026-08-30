<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode, 'colspan'=>14));

if ($caraPrint != 'GRAFIK')
$this->renderPartial('pendapatan/_printTable', array('model'=>$model, 'caraPrint'=>$caraPrint, 'tab' =>$tab)); 

if ($caraPrint == 'GRAFIK')
echo $this->renderPartial('pendapatan/_grafik', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint, 'tab' =>$tab), true); 


?>