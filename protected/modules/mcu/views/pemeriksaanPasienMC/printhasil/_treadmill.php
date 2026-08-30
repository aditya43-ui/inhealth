<?php
$judulLaporanTread = "TREADMIL";
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');

if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
        {
             header('Content-Type: application/vnd.ms-excel');
              header('Content-Disposition: attachment;filename="'.$judulLaporanTread.'-'.date("Y/m/d").'.xls"');
              header('Cache-Control: max-age=0');     
        }
    echo $this->renderPartial('application.views.headerReport.headerDefault1LogoRSKiri',array('judulLaporan'=>$judulLaporanTread, 'colspan'=>3)); 
}else{
    echo $this->renderPartial('application.views.headerReport.headerDefault1LogoRSKiri',array('judulLaporan'=>$judulLaporanTread, 'colspan'=>3)); 
}
?>
<table width="60%" border="1">
    <tr>
        <td style="width:15%">Nama Pasien / No. RM</td>
        <td style="width:15%">: <?php echo $modPasien2->nama_pasien; ?> / <?php echo $modPasien2->no_rekam_medik; ?></td>
        <td style="width:15%">No. Pendaftaran</td>
        <td style="width:15%">: <?php echo $modPendaftaran2->no_pendaftaran; ?></td>
    </tr>
</table>
<table width="100%" class="content" style="border: none;">
<?php 
if (count((array)$modDetail)>0){
foreach ($modDetail as $loop){
?>
    <!-- <tr>
        <td>&nbsp;</td>
        <td align="center" valign="middle" colspan="6" style="font-weight:bold">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            TREADMIL</td>
    </tr> -->
    <tr>
        <td style="width:20%">Nama Pemeriksa</td>
        <td style="width:25%">: <?php echo (isset($loop['namapemeriksa_treadmill']) ? $loop['namapemeriksa_treadmill'] :"-"); ?></td>
        <td style="width:20%">Tanggal Treadmil</td>
        <td style="width:30%">: <?php echo (isset($loop['tgltreadmill']) ? MyFormatter::formatDateTimeForUser($loop['tgltreadmill']) :"-"); ?></td>
    </tr>
    <tr>
        <td style="width:20%">Duration Treadmil</td>
        <td style="width:25%">: <?php echo isset($loop['duration_treadmill'])?$loop['duration_treadmill']:" - "; ?></td>
        <td style="width:20%">Blood Preasure</td>
        <td style="width:30%">: <?php echo isset($loop['td_systolic']) ? $loop['td_systolic']:" - "; ?> / <?php echo isset($loop['td_diastolic']) ? $loop['td_diastolic']:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Heart Rate</td>
        <td style="width:25%">: <?php echo isset($loop['heartrate_treadmill']) ? $loop['heartrate_treadmill']:" - "; ?></td>
        <td style="width:20%">Work Load</td>
        <td style="width:30%">: <?php echo isset($loop['workload_kph']) ? $loop['workload_kph']:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Est. 02 Rate</td>
        <td style="width:25%">: <?php echo isset($loop['est02_rate_min']) ? $loop['est02_rate_min']:" - "; ?></td>
        <td style="width:20%">Max. 02 Intake</td>
        <td style="width:30%">: <?php echo isset($loop['max02_intake']) ? $loop['max02_intake']:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Mets</td>
        <td style="width:25%">: <?php echo isset($loop['mets_treadmill']) ? $loop['mets_treadmill']:" - "; ?></td>
        <td style="width:20%">Fitness Classification</td>
        <td style="width:30%">: <?php echo isset($loop['fitnessclassification']) ? $loop['fitnessclassification']:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Working</td>
        <td style="width:25%">: <?php echo isset($loop['walking_kmhr_treadmill']) ? $loop['walking_kmhr_treadmill']:" - "; ?></td>
        <td style="width:20%">Jogging</td>
        <td style="width:30%">: <?php echo isset($loop['jogging_kmhr_treadmill']) ? $loop['jogging_kmhr_treadmill']:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Bicycling</td>
        <td style="width:25%">: <?php echo isset($loop['bicycling_kmhr_treadmill']) ? $loop['bicycling_kmhr_treadmill']:" - "; ?></td>
        <td style="width:20%">Other Sport</td>
        <td style="width:30%">: <?php echo isset($loop['sports_kmhr_treadmill']) ? $loop['sports_kmhr_treadmill']:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Rest Time</td>
        <td style="width:25%">: <?php echo isset($loop['resttime_menit']) ? $loop['resttime_menit']:" - "; ?></td>
        <td style="width:20%">Work Time</td>
        <td style="width:30%">: <?php echo isset($loop['worktime_menit']) ? $loop['worktime_menit']:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Recovery Time</td>
        <td style="width:25%">: <?php echo isset($loop['recoverytime_menit']) ? $loop['recoverytime_menit']:" - "; ?></td>
        <td style="width:20%">Total Time</td>
        <td style="width:30%">: <?php echo isset($loop['totaltime_menit']) ? $loop['totaltime_menit']:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Interpretation</td>
        <td style="width:25%">: <?php echo isset($loop['interpretation_tradmill']) ? $loop['interpretation_tradmill']:" - "; ?></td>
        <td style="width:20%">Hasil Treadmil</td>
        <td style="width:30%">: <?php echo isset($loop['hasiltreadmill']) ? $loop['hasiltreadmill']:" - "; ?></td>
    </tr>
    <tr><td colspan="6"><hr></td></tr>
<?php }
}else{
?>
    <tr>
        <td colspan="6">* Tidak ada pemeriksaan treadmill</td>
    </tr> 
<?php } ?>
</table> 