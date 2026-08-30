<style>
    #laporanprint-grid th, #laporanprint-grid td{text-align:center;vertical-align:center;}
    #headercolumn {border-bottom:1px solid #DDDDDD;}
    #childcolumn {border-left:1px solid #DDDDDD;}
</style>
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>$periode, 'colspan'=>10));  
?>
<?php $this->renderPartial('neraca/_table2',array('model'=>$model, 'modelLaporan'=>$modelLaporan)); ?>