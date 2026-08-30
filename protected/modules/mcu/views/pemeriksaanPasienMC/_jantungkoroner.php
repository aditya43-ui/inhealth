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
if (count((array)$modJantungKoroner)>0){
foreach ($modJantungKoroner as $i => $loop){
?>
    <tr>
        <td>&nbsp;</td>
        <td align="center" valign="middle" colspan="6" style="font-weight:bold">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            RESIKO JANTUNG KORONER</td>
    </tr>
    <tr>
        <td style="width:20%">Nama Dokter</td>
        <td style="width:25%">: <?php echo (isset($modPendaftaran->pegawai_id) ? $modPendaftaran->pegawai->NamaLengkap :"-"); ?></td>
        <td style="width:20%">Tanggal Hitung Resiko</td>
        <td style="width:30%">: <?php echo (isset($loop->tglhitungresiko) ? MyFormatter::formatDateTimeForUser($loop->tglhitungresiko) :"-"); ?></td>
    </tr>
    <tr>
        <td style="width:20%">Total Kolesterol</td>
        <td style="width:30%">: <?php echo isset($loop->total_kolesterol)?$loop->total_kolesterol:" - "; ?></td>
        <td style="width:15%">Level</td>
        <td style="width:35%">: <?php echo isset($loop->total_kolesterol_level)?$loop->total_kolesterol_level:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:15%">Triglyceride</td>
        <td style="width:30%">: <?php echo isset($loop->triglycerida)?$loop->triglycerida:" - "; ?></td>
        <td style="width:15%">Level</td>
        <td style="width:35%">: <?php echo isset($loop->triglycerida_level)?$loop->triglycerida_level:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:15%">HDL Kolesterol</td>
        <td style="width:30%">: <?php echo isset($loop->hdl_kolesterol)?$loop->hdl_kolesterol:" - "; ?></td>
        <td style="width:15%">Level</td>
        <td style="width:35%">: <?php echo isset($loop->hdl_kolesterol_level)?$loop->hdl_kolesterol_level:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:15%">LDL Koleterol</td>
        <td style="width:30%">: <?php echo isset($loop->ldl_kolesterol)?$loop->ldl_kolesterol:" - "; ?></td>
        <td style="width:15%">Level</td>
        <td style="width:35%">: <?php echo isset($loop->ldl_kolesterol_level)?$loop->ldl_kolesterol_level:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:15%">Tekanan Darah</td>
        <td style="width:30%">: <?php echo isset($loop->tekanandarah)?$loop->tekanandarah:" - "; ?></td>
        <td style="width:15%"></td>
        <td style="width:35%"></td>
    </tr>
    <tr>
        <td style="width:15%">Hasil Total Point</td>
        <td style="width:30%">: <?php echo (isset($loop->hasil_totalpoint)?$loop->hasil_totalpoint:"-"); ?></td>
        <td style="width:15%;height:86px">Resiko dalam 10 tahun</td>
        <td style="width:35%;height:86px">: <?php echo isset($loop->hasil_resiko_persen)?$loop->hasil_resiko_persen:" - "; ?> %</td>
    </tr>
    <tr><td colspan="6"><hr></td></tr>
<?php }
}else{
?>
    <tr>
        <td colspan="6">* Tidak ada pemeriksaan Resiko Penyakit Jantung Koroner</td>
    </tr> 
<?php } ?>
</table> 