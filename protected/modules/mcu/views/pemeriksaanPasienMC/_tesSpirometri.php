<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
        {
             header('Content-Type: application/vnd.ms-excel');
              header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
              header('Cache-Control: max-age=0');     
        }
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));     
}
?>
<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 8pt !important;
        height: 24px;
        padding-left:10px;
    }
    body{
        width: 14.7cm;
    }
    .content td{
        height: 48px;
    }
</style>
<table width="60%" border="1">
    <tr>
        <td style="width:15%">Nama Pasien / No. RM</td>
        <td style="width:15%">: <?php echo $modPasien->nama_pasien; ?> / <?php echo $modPasien->no_rekam_medik; ?></td>
        <td style="width:15%">No. Pendaftaran</td>
        <td style="width:15%">: <?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
</table>
<table width="100%" class="content" style="border: none;">
<?php 
if (count((array)$modTesSpirometri)>0){
foreach ($modTesSpirometri as $i => $loop){
?>
    <tr>
        <td>&nbsp;</td>
        <td align="center" valign="middle" colspan="6" style="font-weight:bold">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            TES SPIROMETRI</td>
    </tr>
    <tr>
        <td style="width:20%">Nama Dokter</td>
        <td style="width:25%">: <?php echo (isset($modPendaftaran->pegawai_id) ? $modPendaftaran->pegawai->NamaLengkap :"-"); ?></td>
        <td style="width:20%">Tanggal SPIROMETRI</td>
        <td style="width:30%">: <?php echo (isset($loop->spirometri_tgl) ? MyFormatter::formatDateTimeForUser($loop->spirometri_tgl) :"-"); ?></td>
    </tr>
    <tr>
        <td style="width:20%">Tes Spirometri</td>
        <td style="width:25%">: <?php echo isset($loop->test_spirometri)?$loop->test_spirometri:" - "; ?></td>
        <td style="width:20%">Tes Reversibilitas</td>
        <td style="width:30%">: <?php echo isset($loop->test_reversibilitas_nilai) ? $loop->test_reversibilitas_nilai:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Social Vital Capacity (SVC)</td>
        <td style="width:30%">Prediksi : <?php echo isset($loop->svc_prediksi)?$loop->svc_prediksi:" - "; ?></td>
        <td style="width:15%">Angka : <?php echo isset($loop->svc)?$loop->svc:" - "; ?></td>
        <td style="width:35%">Persen : <?php echo isset($loop->svc_persen)?$loop->svc_persen:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Forced Vital Capacity (FVC)</td>
        <td style="width:30%">Prediksi : <?php echo isset($loop->fvc_prediksi)?$loop->fvc_prediksi:" - "; ?></td>
        <td style="width:15%">Angka : <?php echo isset($loop->fvc)?$loop->fvc:" - "; ?></td>
        <td style="width:35%">Persen : <?php echo isset($loop->fvc_persen)?$loop->fvc_persen:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Forced Expiratory Volume in one second (FEV1)</td>
        <td style="width:30%">Prediksi : <?php echo isset($loop->fev1_prediksi)?$loop->fev1_prediksi:" - "; ?></td>
        <td style="width:15%">Angka : <?php echo isset($loop->fev1)?$loop->fev1:" - "; ?></td>
        <td style="width:35%">Persen : <?php echo isset($loop->fev1_persen)?$loop->fev1_persen:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:20%">FEV1 / FVC</td>
        <td style="width:30%"></td>
        <td style="width:15%"></td>
        <td style="width:35%">Persen : <?php echo isset($loop->fev1_fvc_persen)?$loop->fev1_fvc_persen:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Peak Expiratory Flow Rate (PFR)</td>
        <td style="width:30%">Prediksi : <?php echo isset($loop->pfr_prediksi)?$loop->pfr_prediksi:" - "; ?></td>
        <td style="width:15%">Angka : <?php echo isset($loop->pfr)?$loop->pfr:" - "; ?></td>
        <td style="width:35%">Persen : <?php echo isset($loop->pfr_persen)?$loop->pfr_persen:" - "; ?></td>
    </tr>
    <tr><td colspan="6"><p style="text-align: center;">Kesimpulan Saran</p></td></tr>
    <tr>
        <td>Kesimpulan</td>
        <td colspan="4"><?php echo isset($loop->kesimpulan)?$loop->kesimpulan:" - "; ?></td>
    </tr>
    <tr>
        <td>Tes Spirometri</td>
        <td colspan="4"><?php echo isset($loop->test_spirometri)?$loop->test_spirometri:" - "; ?></td>
    </tr>
    <tr>
        <td>Tes Reversibilitas </td>
        <td colspan="4"><?php echo isset($loop->test_reversibilitas_nilai)?$loop->test_reversibilitas_nilai:" - "; ?> &nbsp <?php echo isset($loop->test_reversibilitas_is_positif)?$loop->test_reversibilitas_is_positif:" - "; ?></td>
    </tr>
    <tr>
        <td>Saran</td>
        <td colspan="4"><?php echo isset($loop->saran)?$loop->saran:" - "; ?> </td>
    </tr>
    <tr>
        <td>Pegawai Mengetahui</td>
        <td colspan="4"><?php echo isset($loop->pengetahui_id)?$loop->pegawai->NamaLengkap:" - "; ?></td>
    </tr>
<?php }
}else{
?>
    <tr>
        <td colspan="6">* Tidak ada pemeriksaan tes spirometri</td>
    </tr> 
<?php } ?>
</table> 