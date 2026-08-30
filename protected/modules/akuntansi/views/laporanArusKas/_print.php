<?php 
	if($caraPrint=='EXCEL')
	{
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');     
	}
	$period = '';
	if (!empty($model->periodeposting_id)){
		$period = PeriodepostingM::model()->findByPk($model->periodeposting_id)->periodeposting_nama;
	}

	if ($caraPrint != 'PDF'){
		echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> ucwords($period), 'colspan'=>10));  
	}else{
		//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> ucwords($period), 'colspan'=>10));  
	}

	if ($caraPrint != 'GRAFIK')
	$this->renderPartial($this->path_view.'_table', array('model'=>$model, 'models'=>$models, 'caraPrint'=>$caraPrint, /* 'periode'=>$periode */)); 

	if ($caraPrint == 'GRAFIK')
	echo $this->renderPartial('_grafik', array('model'=>$model, 'models'=>$models, 'data'=>$data, 'caraPrint'=>$caraPrint), true); 
?>