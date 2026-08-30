<?php 
	if($caraPrint=='EXCEL')
	{
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');     
	}
	echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>$periode, 'colspan'=>20));  
	$this->renderPartial($this->path_view.'_table', array('model'=>$model, 'models'=>$models, 'caraPrint'=>$caraPrint)); 
?>