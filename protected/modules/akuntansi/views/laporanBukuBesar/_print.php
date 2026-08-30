<?php 
	if($caraPrint=='EXCEL')
	{
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');     
	}
	echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode, 'colspan'=>10));  

	if ($caraPrint != 'GRAFIK')
	$this->renderPartial($this->path_view.'_table', array('model'=>$model, 'caraPrint'=>$caraPrint,'jmlrekening'=>$jmlRekening, 'modelLaporan'=>$modelLaporan)); 

	if ($caraPrint == 'GRAFIK')
	echo $this->renderPartial($this->path_view.'_grafik', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint), true); 
?>