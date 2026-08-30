<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiAkuntansi',array('judulLaporan'=>'Catatan Atas Laporan Keuangan', 'periode'=>$periode, 'colspan'=>10));  

if ($caraPrint != 'PDF'){
    echo '<div id="headers">';
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>"Laporan Catatan Atas Laporan Keuangan",  'colspan'=>3));  
    echo '</div>';
}else{
	//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> ucwords($period), 'colspan'=>10));  
}
?>
<hr>
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td>Tanggal Catatan</td>
        <td>:</td>
        <td><?php echo isset($model->calk_tgl) ? MyFormatter::formatDateTimeId($model->calk_tgl) : "-"; ?></td>
        <td>Periode Rekening</td>
        <td>:</td>
        <td><?php echo isset($model->rekperiod->deskripsi) ? $model->rekperiod->deskripsi : "-"; ?></td>
    </tr>
    <tr>
        <td>No. Catatan</td>
        <td>:</td>
        <td><?php echo isset($model->calk_no) ? $model->calk_no : "-"; ?></td>
    </tr>
</table>
<hr>
<?php
echo $model->calk_catatan;

?>