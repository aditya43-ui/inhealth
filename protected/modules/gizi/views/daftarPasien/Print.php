<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
//echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>7));      

echo $this->renderPartial('details', array('caraPrint'=>$caraPrint,
                                                'modHasilPeriksa'=>$modHasilPeriksa,
                                               'detailHasil'=>$detailHasil,
                                               'hasil'=>$hasil, 
                                               'masukpenunjang'=>$masukpenunjang,
                                               'pemeriksa'=>$pemeriksa));