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
    <tr>
        <td style="width:15%">Umur</td>
        <td style="width:15%">: <?php echo $modPendaftaran->umur; ?></td>
        <td style="width:15%">Alamat</td>
        <td style="width:15%">: <?php echo $modPasien->alamat_pasien;?> <?php echo $modPasien->rt;?> <?php echo $modPasien->rw; ?></td>
    </tr>
</table>
<table width="100%" class="content" style="border: none;">
<?php 
if (!empty($modKelahiran->persalinan_id)){
?>
    <tr>
        <td>&nbsp;</td>
        <td align="center" valign="middle" colspan="6" style="font-weight:bold">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            KELAHIRAN BAYI</td>
    </tr>
    <tr>
	<td style="width:20%">Tanggal Lahir Bayi</td>
        <td style="width:30%">: <?php echo (isset($modKelahiran->tgllahirbayi) ? $modKelahiran->tgllahirbayi :"-"); ?></td>
        <td style="width:20%">Jam Lahir</td>
        <td style="width:30%">: <?php echo (isset($modKelahiran->jamlahir) ? $modKelahiran->jamlahir :"-"); ?></td>
    </tr>
    <tr>
	<td style="width:20%">Nama Bayi</td>
        <td style="width:30%">: <?php echo (isset($modKelahiran->namabayi) ? $modKelahiran->namabayi :"-"); ?></td>
        <td style="width:20%">Jenis Kelamin</td>
        <td style="width:30%">: <?php echo (isset($modKelahiran->jeniskelamin) ? $modKelahiran->jeniskelamin :"-"); ?></td>
    </tr>
    <tr>
	<td style="width:20%">Berat Badan</td>
        <td style="width:30%">: <?php echo (isset($modKelahiran->bb_gram) ? $modKelahiran->bb_gram :"-"); ?> Gram</td>
        <td style="width:20%">Tinggi Badan</td>
        <td style="width:30%">: <?php echo (isset($modKelahiran->tb_cm) ? $modKelahiran->tb_cm :"-"); ?> Cm</td>
    </tr>
    <tr>
	<td style="width:20%">Lahir Tunggal</td>
        <td style="width:30%">: 
	    <?php
		if($modKelahiran->islahirtunggal==true){
		    echo "Ya";
		}else{
		    echo "-";
		}
	    ?>
	</td>
        <td style="width:20%">Lahir Kembar</td>
        <td style="width:30%">: <?php echo (isset($modKelahiran->lahirkembar) ? $modKelahiran->lahirkembar :"-"); ?></td>
        <td style="width:20%">Jumlah Kembar</td>
        <td style="width:30%">: <?php echo (isset($modKelahiran->jmlkembar) ? $modKelahiran->jmlkembar :"-"); ?></td>
    </tr>
    <tr>
	<td style="width:20%">Kelainan Bayi</td>
        <td style="width:30%">: <?php echo (!empty($modKelahiran->kelainanbayi) ? $modKelahiran->kelainanbayi :"-"); ?></td>
        <td style="width:20%">Catatan Bayi</td>
        <td style="width:30%">: <?php echo (!empty($modKelahiran->catatan_bayi) ? $modKelahiran->catatan_bayi :"-"); ?></td>
    </tr>
    <tr><td colspan="6"><hr></td></tr>
<?php 
}else{
?>
    <tr>
        <td colspan="6">* Tidak ada riwayat kelahiran bayi</td>
    </tr> 
<?php } ?>
</table> 