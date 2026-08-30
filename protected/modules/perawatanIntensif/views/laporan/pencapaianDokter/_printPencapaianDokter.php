<style type="text/css">
    .table-striped tbody tr:nth-child(2n+1) td, .table-striped tbody tr:nth-child(2n+1) th {
    background-color: #fff;
}
</style>
<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>10));

if(@$_GET['PILaporanvisitedokterV']['nursestation_id']){
   $nursestation = NursestationM::model()->findByPk(Yii::app()->user->getState('nursestation_id'))->nursestation_nama;
   echo 'NURSESTATION : '.strtoupper($nursestation); 
}
else{
   $nama_ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'))->ruangan_nama;
   echo 'RUANGAN : '.strtoupper($nama_ruangan); 
}

if ($caraPrint != 'GRAFIK')
$this->renderPartial('pencapaianDokter/_tablePencapaianDokter', array('model'=>$model, 'caraPrint'=>$caraPrint)); 

//if ($caraPrint == 'GRAFIK')
//echo $this->renderPartial('_grafik', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint), true); 

?>