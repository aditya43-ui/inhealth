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



	if ($caraPrint != 'PDF'){
		echo "<div id='headers'>";
		echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> $periode, 'colspan'=>10));  
		echo '</div>';
	}else{
		//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> ucwords($period), 'colspan'=>10));  
	}

if ($caraPrint != 'GRAFIK')
$this->renderPartial($this->path_view.'_table', array('model'=>$model, 'caraPrint'=>$caraPrint)); 

$status = null;
if ($status == 'detail')
$this->renderPartial($this->path_view.'detailPrint', array('model'=>$model, 'caraPrint'=>$caraPrint, 'status'=>$status)); 

if ($caraPrint == 'GRAFIK')
echo $this->renderPartial($this->path_view.'_grafik', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint), true); 


?>