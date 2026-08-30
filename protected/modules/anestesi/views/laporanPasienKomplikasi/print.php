<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode, 'colspan'=>10));

if ($caraPrint != 'GRAFIK'){
	if(isset($_GET['ATLapanestesikomplikasiintraV']['pilihan_tab']) && $_GET['ATLapanestesikomplikasiintraV']['pilihan_tab'] == "intra"){
		$this->renderPartial($this->path_view.'_tableIntra', array('model'=>$model, 'caraPrint'=>$caraPrint)); 
	}else{
		$this->renderPartial($this->path_view.'_tablePasca', array('model'=>$model, 'caraPrint'=>$caraPrint)); 
	}
}
if ($caraPrint == 'GRAFIK'){
echo $this->renderPartial($this->path_view.'_grafik', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint, 'searchdata'=>$model->searchReturpenerimaangrafik()), true); 
}

?>