
<style>
    
    .table {
        border-collapse: collapse;
        border: 1px solid black;
    }    
    .table td, .table th {
        border: 1px solid black;
    }
    
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
            height:auto;
        }
    }
	
	
</style><?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}

if ($caraPrint != 'PDF'){
echo '<div id="headers">';
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode, 'colspan'=>10));  
echo '</div>';
}

if ($caraPrint != 'GRAFIK')
$this->renderPartial('rekapKas/_tablePrintBaru', array('nilaiuang'=>$nilaiuang,'model'=>$model, 'modDetail'=>$modDetail,'caraPrint'=>$caraPrint, 'data'=>$data,'rincianUang'=>$rincianUang)); 

if ($caraPrint == 'GRAFIK')
echo $this->renderPartial('_grafik', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint), true); 

?>
