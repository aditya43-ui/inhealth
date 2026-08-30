<?php 
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array(
        'judulLaporan'=>$judulLaporan, 'periode'=>$periode, 'colspan'=>10));  

    if ($caraPrint != 'GRAFIK')
    $this->renderPartial('laboratorium.views.laporan.pemeriksaanRujukan/_printLaporanNew', array('model'=>$model,  'modelRS'=>$modelRS, 'caraPrint'=>$caraPrint, 'tab' => $tab)); 

    if ($caraPrint == 'GRAFIK')
    $this->renderPartial('laboratorium.views.laporan.pemeriksaanRujukan/_grafik', array('model'=>$model, 'modelRS'=>$modelRS,'data'=>$data, 'caraPrint'=>$caraPrint, 'tab' => $tab)); 
?>