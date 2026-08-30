<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>$periode,'colspan'=>10));
if ($caraPrint != 'GRAFIK')
    echo $this->renderPartial('billingKasir.views.laporan.kunjunganPasien/_tableKunjunganPasien', array('model'=>$model, 'caraPrint'=>$caraPrint)); 

if ($caraPrint == 'GRAFIK')
    echo $this->renderPartial('billingKasir.views.laporan._grafik', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint), true); 
?>