<?php 
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/themes/neon18/assets/css/custom.css');

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}


if ($caraPrint != 'PDF'){
	echo '<div id="headers">';
	echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> $periode, 'colspan'=>10));  
	echo '</div>';
}else{
	//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> ucwords($period), 'colspan'=>10));  
}

//echo '<h6 style="text-align:center;color:#333;font-size:10px;">'. .'</h6>';
// if ($caraPrint != 'GRAFIK')
$this->renderPartial($this->path_view.'_table', array('model'=>$model,  'caraPrint'=>$caraPrint)); 


?>