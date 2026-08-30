<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode, 'colspan'=>8));
?>
<div style="text-align: center;">
    <h2><?php echo $judulLaporan; ?></h2>
    <b><?php echo "Periode ".$periode; ?></b>
</div>
<?php
if ($caraPrint != 'GRAFIK'&&$caraPrint != 'EXCEL'){
    $this->renderPartial('totalPendapatanFarmasi/_tablePrint', array('model'=>$model,  'caraPrint'=>$caraPrint));
}
if ($caraPrint == 'EXCEL'){
    $this->renderPartial('totalPendapatanFarmasi/_tableExcel', array('model'=>$model,  'caraPrint'=>$caraPrint));
}
if ($caraPrint == 'GRAFIK')
echo $this->renderPartial('_grafik', array('model'=>$model,  'data'=>$data, 'caraPrint'=>$caraPrint), true); 

?>

<table width="100%" style='margin-top:100px;margin-left:auto;margin-right:auto;'>
    <tr>
        <td width="80%"></td>
        <td><?php echo Yii::app()->user->getState('kabupaten_nama').", ".MyFormatter::formatDateTimeForUser(date('d-m-Y'));?></td>
    </tr>
    <tr style="height: 100px; vertical-align: bottom;">
        <td></td>
        <td>
            <?php echo Yii::app()->user->getState('nama_pegawai'); ?>
        </td>
    </tr>
</table>
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