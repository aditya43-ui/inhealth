
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

echo $this->renderPartial($this->path_view.'informasi/_tabel',['model'=>$model,'caraPrint'=>$caraPrint], true);
?>