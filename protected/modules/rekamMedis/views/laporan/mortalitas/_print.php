<?php 
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinoutHeader.css');
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode, 'colspan'=>13));

if ($caraPrint != 'PDF'){
    echo '<div id="headers">';
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode, 'colspan'=>9));  
    echo '</div>';
}
if ($caraPrint != 'GRAFIK'){
    if ($caraPrint != 'PRINT'){
        $this->renderPartial('mortalitas/_tablePrint', array('model'=>$model, 'caraPrint'=>$caraPrint, 'rincian'=>(isset($data['rincian'])? $data['rincian'] : null) ));
    } else {
        $this->renderPartial('mortalitas/_tablePrint', array('model'=>$model, 'caraPrint'=>$caraPrint, 'rincian'=>(isset($data['rincian'])? $data['rincian'] : null) ));
    }
}
if ($caraPrint == 'GRAFIK')
echo $this->renderPartial('_grafik', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint), true); 

?>

<table width="100%" style='margin-top:100px;margin-left:auto;margin-right:auto;'>
    <tr>
        <td width="50%">
                <label style='float:left;'>Petugas : <?php echo (isset($data['nama_pegawai']) ? $data['nama_pegawai'] : ""); ?></label>

        </td>
        <td width="50%">    
                <label style='float:right;'>Tanggal Print : <?php echo Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-mm-dd hh:mm:ss')); ?></label>
        </td>
    </tr>
</table>