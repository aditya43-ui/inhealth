<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK'){
	if ($model->jenisdiklat_id == Params::JENIS_DIKLAT_EKSTERNAL){
		$this->renderPartial($this->path_view.'realisasiDiklat._tableEksternal', array('model'=>$model, 'caraPrint'=>$caraPrint)); 
	}elseif ($model->jenisdiklat_id == Params::JENIS_DIKLAT_INTERNAL){
		$this->renderPartial($this->path_view.'realisasiDiklat._tableInternal', array('model'=>$model, 'caraPrint'=>$caraPrint, 'modInternal'=>$model)); 
	}
}
if ($caraPrint == 'GRAFIK'){
	echo $this->renderPartial($this->path_view.'_grafik', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint), true); 
}

?>