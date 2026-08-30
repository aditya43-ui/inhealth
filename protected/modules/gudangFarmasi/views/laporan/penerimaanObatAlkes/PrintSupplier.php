<style>
	 @page {
        margin-top: 12mm;
    }
	
	@media print {
        #headers {
            position: fixed;
            top: 0;
        }
        
        body {
            display:table;
            table-layout:fixed;
            padding-top:4cm;
            padding-left: 1mm;
            height:auto;
			width:100%;
        }
    }
</style>

<?php 
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>$periode, 'colspan'=>10));  

if ($caraPrint != 'PDF'){
	echo "<div id='headers'>";
	echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> $periode, 'colspan'=>10));  
	echo '</div>';
}else{
	//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> ucwords($period), 'colspan'=>10));  
}
?>
<?php  //$ruanganAsal = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'))->ruangan_nama;?>
<!--<div style="text-align: center;">
    <h2><?php //echo $judulLaporan; ?></h2>
    <b>Periode : <?php //echo $periode; ?></b><br>
</div>-->
<?php
if ($caraPrint != 'GRAFIK')
$this->renderPartial('penerimaanObatAlkes/_tableSupplier', array('model'=>$model, 'caraPrint'=>$caraPrint)); 

if ($caraPrint == 'GRAFIK')
echo $this->renderPartial('_grafik', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint, 'grafik'=>$grafik), true); 

?>