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
if (count((array)$modAnamnesa)>0){
foreach ($modAnamnesa as $i => $loop){
?>
    <tr>
        <td>&nbsp;</td>
        <td align="center" valign="middle" colspan="6" style="font-weight:bold">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            ANAMNESA</td>
    </tr>
    <tr>
        <td style="width:20%">Nama Dokter</td>
        <td style="width:25%">: <?php echo (isset($loop->pegawai_id) ? $loop->pegawai->NamaLengkap :"-"); ?></td>
        <td style="width:20%">Tanggal Anamnesis</td>
        <td style="width:30%">: <?php echo (isset($loop->tglanamnesis) ? $loop->tglanamnesis :"-"); ?></td>
    </tr>
    <tr>
        <td style="width:20%">Keluhan Utama</td>
        <td style="width:30%">: <?php echo isset($loop->keluhanutama)?$loop->keluhanutama:" - "; ?></td>
        <td style="width:15%">Riwayat Penyakit Keluarga</td>
        <td style="width:35%">: <?php echo isset($loop->riwayatpenyakitkeluarga)?$loop->riwayatpenyakitkeluarga:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:15%">Keluhan Tambahan</td>
        <td style="width:30%">: <?php echo isset($loop->keluhantambahan)?$loop->keluhantambahan:" - "; ?></td>
        <td style="width:15%">Riwayat Perjalanan Pasien</td>
        <td style="width:35%">: <?php echo isset($loop->riwayatperjalananpasien)?$loop->riwayatperjalananpasien:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:15%">Lama sakit</td>
        <td style="width:30%">: <?php echo isset($loop->lamasakit)?$loop->lamasakit:" - "; ?></td>
        <td style="width:15%">Pengobatan Dilakukan</td>
        <td style="width:35%">: <?php echo isset($loop->pengobatanygsudahdilakukan)?$loop->pengobatanygsudahdilakukan:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:15%">Riwayat Alergi Obat</td>
        <td style="width:30%">: <?php echo isset($loop->riwayatalergiobat)?$loop->riwayatalergiobat:" - "; ?></td>
        <td style="width:15%">Riwayat Makanan</td>
        <td style="width:35%">: <?php echo isset($loop->riwayatmakanan)?$loop->riwayatmakanan:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:15%">Riwayat Kelahiran</td>
        <td style="width:30%">: <?php echo isset($loop->riwayatkelahiran)?$loop->riwayatkelahiran:" - "; ?></td>
        <td style="width:15%">Riwayat Imunisasi</td>
        <td style="width:35%">: <?php echo isset($loop->riwayatimunisasi)?$loop->riwayatimunisasi:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:15%">Riwayat Penyakit Terdahulu</td>
        <td style="width:30%">: <?php echo (isset($loop->riwayatpenyakitterdahulu)?$loop->riwayatpenyakitterdahulu:"-"); ?></td>
        <td style="width:15%;height:86px">Keterangan</td>
        <td style="width:35%;height:86px">: <?php echo isset($loop->keterangananamesa)?$loop->keterangananamesa:" - "; ?></td>
    </tr>
    <tr><td colspan="6"><hr></td></tr>
<?php }
}else{
?>
    <tr>
        <td colspan="6">* Tidak ada pemeriksaan Anamnesis</td>
    </tr> 
<?php } ?>
</table> 