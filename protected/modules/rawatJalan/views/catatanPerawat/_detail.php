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
        vertical-align: top;
        color: black;
    }
    body{
        width: 14.7cm;
    }
    .content td{
        height: 10px;
    }
    
    .tab_skrining th, .tab_skrining td {
        color: black;
        border: 1px solid black;
        padding: 2px;
    }
    
    .tab_skrining th {
        text-align: center;
        font-weight: bold;
    }
    
    .tab_skrining tfoot td {
        font-weight: bold;
    }
    
    .pilih_center {
        text-align: center;
    }
    
    
    .tab_vaksinasi {
        width: 100%;
    }
    
    .tab_vaksinasi th, .tab_vaksinasi td {
        border: 1px solid black;
        padding: 2px;
        text-align: center;
        vertical-align: middle;
        height: auto;
    }
    
    .tab_vaksinasi th {
        font-weight: bold;
    }
    
    .form_anak td {
        padding: 2px;
        height: auto;
    }
    
    .tab_strong_kids {
        width: 100%;
    }
    
    .tab_strong_kids th, .tab_strong_kids td {
        border: 1px solid black;
        padding: 2px;
        vertical-align: top;
        height: auto;
    }
    
    .tab_strong_kids th {
        font-weight: bold;
        text-align: center;
        vertical-align: middle;
    }
    
    .tab_strong_kids .skcenter {
        text-align: center;
        vertical-align: middle;
    }
    
    .num {
        text-align: right;
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
<table width="100%" border="0" class="content">
<?php 
if (!empty($modCatatan)){
foreach ($modCatatan as $i => $loop){
?>
    <tr>
        <td align="center" valign="middle" colspan="2" style="font-weight:bold; border-top: 2px solid black;">
            Catatan Perawat
        </td>
    </tr>
    <tr>
        <td style="width: 120px">Tanggal/ Jam Observasi</td>
        <td style="width:30%">: <?php echo MyFormatter::formatDateTimeForUser($loop->tglobservasi); ?></td>
    </tr>
    <tr>
        <td>Dokter</td>
        <td>: <?php echo ""; ?></td>
    </tr>
    <tr>
        <td>Perawat</td>
        <td>: <?php echo (!empty($loop->perawatmengetahui)?$loop->perawatmengetahui->namaLengkap:" - "); ?></td>
    </tr>
    <tr>
        <td>Catatan Perawat</td>
        <td>: <?php echo $loop->catatanperawat; ?></td>
    </tr>
    <tr>
        <td colspan="2">
            <br/><br/><br/>
            Dibuat Oleh: <?php 
                $peg = LoginpemakaiK::model()->findByPk($loop->create_loginpemakai_id);
                echo (!empty($peg)? (!empty($peg->pegawai)?$peg->pegawai->namaLengkap : "") : "");
            ?>
        </td>
    </tr>
    
    </tr>
<?php }
}else{
?>
    
<?php } ?>
</table> 
