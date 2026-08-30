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
        /*height: 48px;*/
    }
</style>    
<table width="60%" border="1">
    <tr>
        <td style="width:15%">Nama Pasien / DMK</td>
        <td style="width:15%">: <?php echo $modPasien->nama_pasien; ?> / <?php echo $modPasien->no_rekam_medik; ?></td>
        <td style="width:15%">No. Pendaftaran</td>
        <td style="width:15%">: <?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
</table>
<table width="100%" class="content" style="border: none;">
<?php 
if (count((array)$modPemeriksaanFisik)>0){
foreach ($modPemeriksaanFisik as $i => $loop){
?>
    <tr>
        <td>&nbsp;</td>
        <td align="center" valign="middle" colspan="4" style="font-weight:bold;">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;
            PERIKSA FISIK</td>
    </tr>
    <tr>
        <td style="width:20%">Nama Dokter</td>
        <td style="width:25%">: <?php echo (isset($loop->pegawai_id) ? $loop->pegawai->nama_pegawai :"-"); ?></td>
        <td style="width:20%">Tanggal Periksa</td>
        <td style="width:30%">: <?php echo (isset($loop->tglperiksafisik) ? $loop->tglperiksafisik :"-"); ?></td>
    </tr>
    <tr>
        <td width="20%">Inspeksi</td>
        <td width="30%">: <?php echo isset($loop->inspeksi)?$loop->inspeksi:" - "; ?></td>
        <td width="15%">Kepala</td>
        <td width="35%">: <?php echo isset($loop->kepala)?$loop->kepala:" - "; ?></td>
    </tr>
    <tr>
        <td width="15%">Palpasi</td>
        <td width="30%">: <?php echo isset($loop->palpasi)?$loop->palpasi:" - "; ?></td>
        <td width="15%">Hidung</td>
        <td width="35%">: <?php echo isset($loop->hidung)?$loop->hidung:" - "; ?></td>
    </tr>
    <tr>
        <td width="15%">Detak Nadi</td>
        <td width="30%">: <?php echo (isset($loop->detaknadi)?$loop->detaknadi:" - ").' /Menit'; ?></td>
        <td width="15%">Mata</td>
        <td width="35%">: <?php echo isset($loop->mata)?$loop->mata:" - "; ?></td>
    </tr>
    <tr>
        <td width="15%">Denyut Jantung</td>
        <td width="30%">: <?php echo (isset($loop->denyutjantung)?$loop->denyutjantung:" - "); ?></td>
        <td width="15%">Tenggorokan</td>
        <td width="35%">: <?php echo isset($loop->tenggorokan)?$loop->tenggorokan:" - "; ?></td>
    </tr>
    <tr>
        <td width="15%">Tekanan Darah</td>
        <td width="30%">: <?php echo (isset($loop->tekanandarah)?$loop->tekanandarah:" - ").' /MmHg'; ?></td>
        <td width="15%">Leher</td>
        <td width="35%">: <?php echo isset($loop->leher)?$loop->leher:" - "; ?></td>
    </tr>
    <tr>
        <td width="15%">Mean Arterial Pressure</td>
        <td width="30%">: <?php echo isset($loop->meanarteripressure)?$loop->meanarteripressure:" - "; ?></td>
        <td width="15%">Payudara</td>
        <td width="35%">: <?php echo isset($loop->payudara)?$loop->payudara:" - "; ?></td>
    </tr>
    <tr>
        <td width="15%">Suhu Tubuh</td>
        <td width="30%">: <?php echo (isset($loop->suhutubuh)?$loop->suhutubuh:" - ").' &deg; Celcius'; ?></td>
        <td width="15%">Telinga</td>
        <td width="35%">: <?php echo isset($loop->telinga)?$loop->telinga:" - "; ?></td>
    </tr>
    <tr>
        <td width="15%">Perkusi</td>
        <td width="30%">: <?php echo isset($loop->perkusi)?$loop->perkusi:" - "; ?></td>
        <td width="15%">Abdomen</td>
        <td width="35%">: <?php echo isset($loop->abdomen)?$loop->abdomen:" - "; ?></td>
    </tr>
    <tr>
        <td width="15%">Auskultasi</td>
        <td width="30%">: <?php echo isset($loop->auskultasi)?$loop->auskultasi:" - "; ?></td>
        <td width="15%">Jantung</td>
        <td width="35%">: <?php echo isset($loop->jantung)?$loop->jantung:" - "; ?></td>
    </tr>
    <tr>
        <td width="15%">Tinggi badan / Berat badan</td>
        <td width="30%">: <?php echo (isset($loop->tinggibadan_cm)?$loop->tinggibadan_cm:" - ").' Cm / '.(isset($modPemeriksaanFisik->beratbadan_kg)?$modPemeriksaanFisik->beratbadan_kg:" - ").' Kg'; ?></td>
        <td width="15%">Kulit</td>
        <td width="35%">: <?php echo isset($loop->kulit)?$loop->kulit:" - "; ?></td>
    </tr>
    <tr>
        <td width="15%">Index Masa Tubuh</td>
        <td width="30%">: <?php echo (isset($loop->indexmassatubuh)?$loop->indexmassatubuh:" - "); ?></td>
    </tr>
    <tr>
        <td width="15%">Pernapasan</td>
        <td width="30%">: <?php echo (isset($loop->pernapasan)?$loop->pernapasan:" - ").' /Menit'; ?></td>
    </tr>
    <tr>
        <td width="15%">Kelainan Pada Bagian Tubuh</td>
        <td width="30%">: <?php echo isset($loop->kelainanpadabagtubuh)?$loop->kelainanpadabagtubuh:" - "; ?></td>
    </tr>
    <tr><td colspan="6"><hr></td></tr>
<?php }
}else{
?>
    <tr>
        <td colspan="6">* Tidak ada pemeriksaan fisik</td>
    </tr> 
<?php } ?>
</table>
