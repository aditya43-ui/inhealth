<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("d/m/Y").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefaultLaporanNew',array('judulLaporan'=>$judulLaporan, 'periode'=>$periode,'colspan'=>11));  

$this->renderPartial($this->path_view_lap.'rekapTrendPenghasilanTahun/_table', array('model'=>$model, 'caraPrint'=>$caraPrint)); 

?>