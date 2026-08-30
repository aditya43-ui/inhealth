<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>$periode, 'colspan'=>10));  
?>
<?php  $ruanganAsal = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'))->ruangan_nama;?>
<div style="text-align: center;">
    <h2><?php echo $judulLaporan; ?></h2>
    <b>Periode : <?php echo $periode; ?></b><br>
    <b>Ruangan : <?php echo $ruanganAsal; ?></b>
</div>
<?php
if ($caraPrint != 'GRAFIK')
    $this->renderPartial($this->path_view.'_table', array('model'=>$model, 'caraPrint'=>$caraPrint)); 

if ($caraPrint == 'GRAFIK')
echo $this->renderPartial($this->path_view.'_grafik', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint), true); 
if(isset($caraPrint))
$this->renderPartial($this->path_view.'_tandatangan', array('model'=>$model, 'caraPrint'=>$caraPrint));
?>
