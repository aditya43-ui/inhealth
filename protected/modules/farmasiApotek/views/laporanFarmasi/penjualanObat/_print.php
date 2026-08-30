<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode, 'colspan'=>14));

if ($caraPrint != 'GRAFIK'){
//    if (($caraPrint != 'PRINT') || (!empty($data['rincian']))){
//        $this->renderPartial('penjualanObat/_tableRincian', array('model'=>$model, 'caraPrint'=>$caraPrint, 'rincian'=>$data['rincian']));
//    } else {
        $this->renderPartial('penjualanObat/_tablePrint', array('model'=>$model, 'caraPrint'=>$caraPrint,));
//    }
}
if ($caraPrint == 'GRAFIK') {
$this->renderPartial('_grafik', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint), true); 
}

?>

<table width="100%" style='margin-top:100px;margin-left:auto;margin-right:auto;'>
    <tr>
        <td width="50%">
                <label style='float:left;'>Petugas : <?php echo $data['nama_pegawai']; ?></label>

        </td>
        <td width="50%">    
                <label style='float:right;'>Tanggal Print : <?php echo Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-mm-dd hh:mm:ss')); ?></label>
        </td>
    </tr>
</table>