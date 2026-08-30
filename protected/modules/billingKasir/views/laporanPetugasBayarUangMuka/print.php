<?php
$periode = MyFormatter::formatDateTimeId(date('Y-m-d'));
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'periode' => $periode, 'colspan' => 9));
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

$petugas_id = Yii::app()->user->getState('pegawai_id');
$petugas = PegawaiM::model()->findByPk($petugas_id);

if ($caraPrint == 'PDF') {
    ?>
    <div class="header">
        <?php   
        $billing = "";
        
        echo $this->renderPartial('billingKasir.views.laporanPetugasBayarUangMuka.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => $periode, 'billing'=>$billing)); ?><br>
    </div>
    <div class="content">

        <?php
       $this->renderPartial('billingKasir.views.laporanPetugasBayarUangMuka._tablePrint', array('model'=>$model, 'caraPrint'=>$caraPrint)); 
        ?>
        <table width="100%" style="margin-top: 50px;">
            <tr>
                <td>&nbsp;</td>
                <td width="400" style="text-align: center;">
                    <?php echo Yii::app()->user->getState('kabupaten_nama').", ".MyFormatter::formatDateTimeID(date('Y-m-d')); ?><br/>
                    Nama Petugas
                    <br/><br/><br/><br/><br/>
                    <u><?php echo $petugas->namaLengkap ?? "-"; ?></u><br/>
                    <?php echo $petugas->nomorindukpegawai ?? "-"; ?>
                </td>
            </tr>
        </table>
    </div>

    <?php
}



?>