<?php
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode, 'colspan'=>10));
?>

<?php $this->renderPartial('_table', array('model'=>$model, 'caraPrint'=>$caraPrint)); ?>

<table width="100%" style='margin-top:50px;margin-left:auto;margin-right:auto;text-align:center;'>
    <tr>
        <td width="60%">
        </td>
        <td width="30%">    
                <span><?php echo $data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS())->kabupaten->kabupaten_nama; ?>, <?php echo MyFormatter::formatDateTimeId(date('Y-m-d')); ?></span>
        </td>
        <td width="10%"><td>
    </tr>
    <tr>
        <td width="60%">
        </td>
        <td width="30%">    
                <span>Mengetahui</span>
        </td>
        <td width="10%"><td>
    </tr>
    <tr>
        <td width="60%" style="height:100px">
        </td>
        <td width="30%">    
        <td width="10%"><td>
    </tr>
    <tr>
        <td width="60%">
        </td>
        <td width="30%">    
                <span>( <?php echo $data['nama_pegawai']; ?> )</span>
        </td>
        <td width="10%"><td>
    </tr>
</table>