<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("d/m/Y").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>$periode,'colspan'=>10));  

$this->renderPartial($this->path_view.'pajak/_tablePajak', array('model'=>$model, 'caraPrint'=>$caraPrint)); 

?>