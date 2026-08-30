<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'periode' => $periode, 'colspan' => 9));
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint == 'PDF') {
    ?>
    <div class="header">
        <?php   echo $this->renderPartial('rawatJalan.views.laporanPerPetugas.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => $periode)); ?><br>
    </div>
    <div class="content">

        <?php
       $this->renderPartial('rawatJalan.views.laporanPerPetugas._table', array('model'=>$model, 'caraPrint'=>$caraPrint)); 
        ?>
    </div>

    <?php
}

$petugas_id = Yii::app()->user->getState('pegawai_id');
$petugas = PegawaiM::model()->findByPk($petugas_id);

?>

<table style="margin-left: 60%; margin-top: 25px;">
    <tr>
        <td>Malang, <?php echo MyFormatter::formatDateTimeId(date('Y-m-d'))?></td>
    </tr>
    <tr>
        <td>Nama Petugas</td>
    </tr>
    <tr>
        <td>
            <br><br><br>
            <br><br><br>
            <br><br>
        </td>
    </tr>
    <tr>
        <td><?php echo $petugas->namaLengkap ?></td>
    </tr>
    <tr>
        <td>(NIP) <?php echo $petugas->nomorindukpegawai ?> </td>
    </tr>
</table>