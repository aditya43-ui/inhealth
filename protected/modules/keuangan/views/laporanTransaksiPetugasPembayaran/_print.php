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
        <?php   
        $billing = "";
        
        echo $this->renderPartial('keuangan.views.laporanTransaksiPetugasPembayaran.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => $periode, 'billing'=>$billing)); ?><br>
    </div>
    <div class="content">

        <?php
       $this->renderPartial('keuangan.views.laporanTransaksiPetugasPembayaran._table', array('model'=>$model, 'caraPrint'=>$caraPrint)); 
        ?>
    </div>

    <?php
}

$petugas_id = Yii::app()->user->getState('pegawai_id');
$petugas = PegawaiM::model()->findByPk($petugas_id);

?>