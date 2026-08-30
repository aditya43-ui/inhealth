<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>$periode,'colspan'=>10));  

if ($caraPrint != 'GRAFIK')
$this->renderPartial($this->path_view.'reevaluasiAset/_tableReevaluasi', array('model'=>$model, 'caraPrint'=>$caraPrint)); 



?>