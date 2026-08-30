<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode, 'colspan'=>12));

if ($caraPrint != 'GRAFIK'){
	$criteria = new CDbCriteria();
	$criteria->addBetweenCondition('tgl_pendaftaran', $model->tgl_awal, $model->tgl_akhir);
	$models = HDLaporanaustralasiantriageV::model()->findAll($criteria);
	
	$this->renderPartial('australasianTriage/_tableAustralasianTriage', array('models'=>$models, 'caraPrint'=>$caraPrint)); 
}

if ($caraPrint == 'GRAFIK')
echo $this->renderPartial('_grafik', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint), true); 


?>